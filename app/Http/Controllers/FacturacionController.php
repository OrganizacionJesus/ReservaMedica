<?php

namespace App\Http\Controllers;

use App\Models\FacturaPaciente;
use App\Models\FacturaCabecera;
use App\Models\FacturaDetalle;
use App\Models\FacturaTotal;
use App\Models\Cita;
use App\Models\TasaDolar;
use App\Models\ConfiguracionReparto;
use App\Services\FacturacionService;
use App\Services\LiquidacionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class FacturacionController extends Controller
{
    protected FacturacionService $facturacionService;
    protected LiquidacionService $liquidacionService;

    public function __construct(
        FacturacionService $facturacionService,
        LiquidacionService $liquidacionService
    ) {
        $this->facturacionService = $facturacionService;
        $this->liquidacionService = $liquidacionService;
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $tipo = $request->get('tipo', 'pacientes'); // 'pacientes' o 'internas'
        
        if ($tipo === 'internas') {
            // Mostrar facturas internas POR ENTIDAD
            $entidadTipo = $request->get('entidad', 'Medico'); // 'Medico', 'Consultorio', o 'Sistema'
            
            // Obtener FacturaTotal filtrado por tipo de entidad
            $query = \App\Models\FacturaTotal::with([
                'cabecera.cita.paciente',
                'cabecera.cita.medico',
                'cabecera.cita.especialidad',
                'cabecera.cita.consultorio',
                'cabecera.tasa'
            ])
            ->where('factura_totales.status', true)
            ->where('entidad_tipo', $entidadTipo);

            // Filtrar por consultorio si no es Root
            if ($user && $user->administrador && $user->administrador->tipo_admin !== 'Root') {
                $consultorioIds = $user->administrador->consultorios()->pluck('consultorios.id');
                $query->whereHas('cabecera.cita', function($q) use ($consultorioIds) {
                    $q->whereIn('consultorio_id', $consultorioIds);
                });
            }

            // Calcular estadísticas POR ENTIDAD
            $statsQuery = \App\Models\FacturaTotal::where('factura_totales.status', true);
            
            if ($user && $user->administrador && $user->administrador->tipo_admin !== 'Root') {
                $consultorioIds = $user->administrador->consultorios()->pluck('consultorios.id');
                $statsQuery->whereHas('cabecera.cita', function($q) use ($consultorioIds) {
                    $q->whereIn('consultorio_id', $consultorioIds);
                });
            }

            $stats = [
                'total_medico' => $statsQuery->clone()->where('entidad_tipo', 'Medico')->sum('total_final_usd'),
                'total_consultorio' => $statsQuery->clone()->where('entidad_tipo', 'Consultorio')->sum('total_final_usd'),
                'total_sistema' => $statsQuery->clone()->where('entidad_tipo', 'Sistema')->sum('total_final_usd'),
                'count_medico' => $statsQuery->clone()->where('entidad_tipo', 'Medico')->count(),
                'count_consultorio' => $statsQuery->clone()->where('entidad_tipo', 'Consultorio')->count(),
                'count_sistema' => $statsQuery->clone()->where('entidad_tipo', 'Sistema')->count(),
            ];

            $facturas = $query->orderBy('created_at', 'desc')->paginate(10);
            return view('shared.facturacion.index', compact('facturas', 'stats', 'tipo', 'entidadTipo'));
            
        } else {
            // Mostrar facturas de pacientes (FacturaPaciente) - código original
            $query = FacturaPaciente::with(['cita.paciente', 'cita.medico', 'cita.especialidad', 'tasa'])
                                      ->where('status', true);

            if ($user && $user->administrador && $user->administrador->tipo_admin !== 'Root') {
                $consultorioIds = $user->administrador->consultorios()->pluck('consultorios.id');
                $query->whereHas('cita', function($q) use ($consultorioIds) {
                    $q->whereIn('consultorio_id', $consultorioIds);
                });
            }

            // Calcular estadísticas
            $stats = [
                'cobradas' => $query->clone()->where('status_factura', 'Pagada')->sum('monto_usd'),
                'pendientes' => $query->clone()->where('status_factura', 'Emitida')->sum('monto_usd'),
                'vencidas' => $query->clone()->where('status_factura', 'Emitida')
                                           ->where('fecha_vencimiento', '<', now())->sum('monto_usd'),
                'total' => $query->count()
            ];

            $facturas = $query->paginate(10);
            return view('shared.facturacion.index', compact('facturas', 'stats', 'tipo'));
        }
    }

    public function create()
    {
        $user = auth()->user();
        $query = FacturaPaciente::with([
                'cita.paciente', 
                'cita.medico', 
                'cita.especialidad', 
                'cita.consultorio',
                'pagos'
            ])
            ->where('status', true)
            ->where('status_factura', 'Emitida')
            ->whereHas('pagos', function($q) {
                $q->where('estado', 'Pendiente');
            });

        if ($user && $user->administrador && $user->administrador->tipo_admin !== 'Root') {
            $consultorioIds = $user->administrador->consultorios()->pluck('consultorios.id');
            $query->whereHas('cita', function($q) use ($consultorioIds) {
                $q->whereIn('consultorio_id', $consultorioIds);
            });
        }

        $facturas = $query->get();
        
        $tasas = TasaDolar::where('status', true)
                          ->orderBy('fecha_tasa', 'desc')
                          ->get();
        
        return view('shared.facturacion.create', compact('facturas', 'tasas'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        try {
            $validator = Validator::make($request->all(), [
                'cita_id' => 'required|exists:citas,id|unique:facturas_pacientes,cita_id',
                'tasa_id' => 'required|exists:tasas_dolar,id',
                'fecha_emision' => 'required|date',
                'fecha_vencimiento' => 'nullable|date',
                'numero_factura' => 'nullable|unique:facturas_pacientes,numero_factura'
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $cita = Cita::with(['medico', 'consultorio'])->findOrFail($request->cita_id);
            $tasa = TasaDolar::findOrFail($request->tasa_id);

            // Calcular monto en bolívares
            $montoBS = $cita->tarifa * $tasa->valor;

            // Generar número de factura si no se proporcionó uno
            $numeroFactura = $request->numero_factura;
            if (!$numeroFactura) {
                $year = date('Y');
                $count = FacturaPaciente::whereYear('fecha_emision', $year)->count() + 1;
                $numeroFactura = 'FAC-' . $year . '-' . str_pad($count, 6, '0', STR_PAD_LEFT);
            }

            $factura = FacturaPaciente::create([
                'cita_id' => $cita->id,
                'paciente_id' => $cita->paciente_id,
                'medico_id' => $cita->medico_id,
                'monto_usd' => $cita->tarifa,
                'tasa_id' => $tasa->id,
                'monto_bs' => $montoBS,
                'fecha_emision' => $request->fecha_emision,
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'numero_factura' => $numeroFactura,
                'status_factura' => 'Emitida',
                'status' => true
            ]);

            // ✅ Usar el servicio de facturación
            $this->facturacionService->ejecutarFacturacionAvanzada($cita);

            DB::commit();
            return redirect()->route('facturacion.show', $factura->id)
                           ->with('success', 'Factura creada exitosamente');
            
        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->validator)->withInput();
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creando factura: ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'Error al crear la factura: ' . $e->getMessage())
                           ->withInput();
        }
    }

    public function show(Request $request, $id)
    {
        $tipo = $request->get('tipo', 'paciente');
        
        if ($tipo === 'interna') {
            // Mostrar factura de una entidad específica con las relacionadas
            // $id es el ID de FacturaTotal
            $facturaSeleccionada = \App\Models\FacturaTotal::with([
                'cabecera.cita.paciente',
                'cabecera.cita.medico.datosPago.metodoPago',
                'cabecera.cita.especialidad',
                'cabecera.cita.consultorio',
                'cabecera.tasa'
            ])->findOrFail($id);
            
            // Obtener todas las facturas de las otras entidades (misma cabecera)
            $facturasRelacionadas = \App\Models\FacturaTotal::with([
                'cabecera.cita.medico.datosPago.metodoPago'
            ])
            ->where('cabecera_id', $facturaSeleccionada->cabecera_id)
            ->where('id', '!=', $id) // Excluir la seleccionada
            ->where('status', true)
            ->get();
            
            // Obtener la factura del paciente relacionada (misma cita)
            $facturaPaciente = FacturaPaciente::with(['pagos.metodoPago', 'tasa'])
                ->where('cita_id', $facturaSeleccionada->cabecera->cita_id)
                ->first();
            
            // Obtener todos los detalles de la cabecera
            $detalles = \App\Models\FacturaDetalle::where('cabecera_id', $facturaSeleccionada->cabecera_id)
                ->where('status', true)
                ->get();
            
            return view('shared.facturacion.show-interna', compact(
                'facturaSeleccionada', 
                'facturasRelacionadas', 
                'facturaPaciente',
                'detalles'
            ));
            
        } else {
            // Mostrar factura de paciente (FacturaPaciente)
            $factura = FacturaPaciente::with([
                'cita.paciente', 
                'cita.medico', 
                'cita.especialidad',
                'cita.facturaCabecera.detalles',
                'cita.facturaCabecera.totales',
                'tasa',
                'pagos.metodoPago',
                'pagos.confirmadoPor'
            ])->findOrFail($id);

            return view('shared.facturacion.show', compact('factura'));
        }
    }

    public function edit($id)
    {
        $factura = FacturaPaciente::findOrFail($id);
        $tasas = TasaDolar::where('status', true)->orderBy('fecha_tasa', 'desc')->get();
        return view('shared.facturacion.edit', compact('factura', 'tasas'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tasa_id' => 'required|exists:tasas_dolar,id',
            'fecha_emision' => 'required|date',
            'fecha_vencimiento' => 'nullable|date',
            'numero_factura' => 'nullable|unique:facturas_pacientes,numero_factura,' . $id,
            'status_factura' => 'required|in:Emitida,Pagada,Anulada,Vencida'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $factura = FacturaPaciente::findOrFail($id);
        $tasa = TasaDolar::findOrFail($request->tasa_id);

        // Recalcular monto en bolívares
        $montoBS = $factura->monto_usd * $tasa->valor;

        $factura->update([
            'tasa_id' => $tasa->id,
            'monto_bs' => $montoBS,
            'fecha_emision' => $request->fecha_emision,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'numero_factura' => $request->numero_factura,
            'status_factura' => $request->status_factura
        ]);

        return redirect()->route('facturacion.index')->with('success', 'Factura actualizada exitosamente');
    }

    public function destroy($id)
    {
        $factura = FacturaPaciente::findOrFail($id);
        $factura->update(['status' => false]);

        return redirect()->route('facturacion.index')->with('success', 'Factura eliminada exitosamente');
    }

    public function enviarRecordatorio($id)
    {
        $factura = FacturaPaciente::with(['cita.paciente.usuario'])->findOrFail($id);
        
        try {
            Mail::send('emails.recordatorio-pago', ['factura' => $factura], function($message) use ($factura) {
                $message->to($factura->cita->paciente->usuario->correo)
                        ->subject('Recordatorio de Pago - Factura #' . $factura->numero_factura);
            });
            
            return redirect()->back()->with('success', 'Recordatorio enviado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al enviar el recordatorio: ' . $e->getMessage());
        }
    }

    // ❌ ELIMINADO: Métodos duplicados de facturación movidos a FacturacionService
    // - crearFacturacionAvanzada()
    // - generarNumeroControl()
    // - crearDetallesFactura()
    // - crearTotalesFactura()



    public function crearLiquidacion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'entidad_tipo' => 'required|in:Medico,Consultorio',
            'entidad_id' => 'required|integer',
            'periodo_tipo' => 'required|in:quincenal,mensual,manual',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'metodo_pago' => 'required|in:Transferencia,Zelle,Efectivo,Pago Movil,Otro',
            'referencia' => 'required|string|max:100',
            'fecha_pago' => 'required|date|before_or_equal:today',
            'observaciones' => 'nullable|string|max:1000'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        try {
            $fechaInicio = \Carbon\Carbon::parse($request->fecha_inicio)->startOfDay();
            $fechaFin = \Carbon\Carbon::parse($request->fecha_fin)->endOfDay();
            
            $liquidacion = $this->liquidacionService->generarLiquidacionPorPeriodo(
                $request->entidad_tipo,
                $request->entidad_id,
                $request->periodo_tipo,
                $fechaInicio,
                $fechaFin,
                [
                    'metodo_pago' => $request->metodo_pago,
                    'referencia' => $request->referencia,
                    'fecha_pago' => $request->fecha_pago,
                    'observaciones' => $request->observaciones
                ]
            );
            
            return redirect()->route('facturacion.liquidaciones')
                           ->with('success', 'Liquidación generada exitosamente');
                           
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
    /**
     * Mostrar vista de liquidaciones con totales pendientes
     */
    public function resumenLiquidaciones()
    {
        $user = auth()->user();
        $isLocalAdmin = $user && $user->administrador && $user->administrador->tipo_admin !== 'Root';
        $consultorioIds = [];

        if ($isLocalAdmin) {
            $consultorioIds = $user->administrador->consultorios()->pluck('consultorios.id');
        }

        // Usar el service para obtener resumen de pendientes
        $resumen = $this->liquidacionService->obtenerResumenPendientes(null, $consultorioIds);
        
        // Obtener próximos períodos para liquidar
        $proximaQuincena = PeriodoCalculator::getProximoPeriodo('quincenal');
        $proximoMensual = PeriodoCalculator::getProximoPeriodo('mensual');

        return view('shared.facturacion.liquidaciones', [
            'totalesPendientes' => $resumen['totales_pendientes'],
            'totalesPorEntidad' => $resumen['totales_por_entidad'],
            'proximaQuincena' => $proximaQuincena,
            'proximoMensual' => $proximoMensual,
            'resumen' => $resumen['resumen']
        ]);
    }
}