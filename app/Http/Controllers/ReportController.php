<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\Consultorio;
use App\Models\FacturaPaciente;
use App\Models\Pago;
use App\Models\Especialidad;
use App\Models\EvolucionClinica;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    private function getBaseQueryFilters($request)
    {
        $admin = auth()->user()->administrador;
        $isRoot = $admin->tipo_admin === 'Root';
        $consultorioIds = $isRoot ? null : $admin->consultorios->pluck('id');

        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfDay()->format('Y-m-d'));

        return [
            'isRoot' => $isRoot,
            'consultorioIds' => $consultorioIds,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'request_consultorio_id' => $request->consultorio_id,
            'request_ciudad_id' => $request->ciudad_id,
        ];
    }

    public function index(Request $request)
    {
        $filters = $this->getBaseQueryFilters($request);
        $isRoot = $filters['isRoot'];
        $consultorioIds = $filters['consultorioIds'];
        $startDate = $filters['startDate'];
        $endDate = $filters['endDate'];

        $queryCitas = Cita::whereBetween('fecha_cita', [$startDate, $endDate]);
        $queryFacturas = FacturaPaciente::whereBetween('fecha_emision', [$startDate, $endDate]);

        if (!$isRoot) {
            $queryCitas->whereIn('consultorio_id', $consultorioIds);
            $queryFacturas->whereHas('cita', function ($q) use ($consultorioIds) {
                $q->whereIn('consultorio_id', $consultorioIds);
            });
        }

        $totalCitas = (clone $queryCitas)->count();
        $citasCompletadas = (clone $queryCitas)->where('estado_cita', 'Completada')->count();
        $citasAusentes = (clone $queryCitas)->where('estado_cita', 'No Asistió')->count();
        $noShowRate = $totalCitas > 0 ? round(($citasAusentes / $totalCitas) * 100, 2) : 0;
        $ingresosTotal = (clone $queryFacturas)->sum('monto_usd');

        // Datos para gráfico de tendencias (últimos 6 meses o periodo actual)
        $chartData = (clone $queryCitas)
            ->select(
                DB::raw('DATE_FORMAT(fecha_cita, "%Y-%m") as mes'),
                DB::raw('count(*) as total'),
                DB::raw('sum(case when estado_cita = "Completada" then 1 else 0 end) as completadas'),
                DB::raw('sum(case when estado_cita = "No Asistió" then 1 else 0 end) as ausentes')
            )
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        return view('admin.reportes.index', compact(
            'totalCitas',
            'citasCompletadas',
            'noShowRate',
            'ingresosTotal',
            'startDate',
            'endDate',
            'isRoot',
            'chartData'
        ));
    }

    public function operatividad(Request $request)
    {
        $filters = $this->getBaseQueryFilters($request);
        $isRoot = $filters['isRoot'];
        $consultorioIds = $filters['consultorioIds'];
        $startDate = $filters['startDate'];
        $endDate = $filters['endDate'];

        $queryCitas = Cita::whereBetween('fecha_cita', [$startDate, $endDate]);

        // Filtro de consultorio específico o por ciudad
        if ($request->has('consultorio_id') && $request->consultorio_id != '') {
            $queryCitas->where('consultorio_id', $request->consultorio_id);
        } elseif ($request->has('ciudad_id') && $request->ciudad_id != '') {
            $cityConsultorios = Consultorio::where('ciudad_id', $request->ciudad_id)->pluck('id');
            $queryCitas->whereIn('consultorio_id', $cityConsultorios);
        } elseif (!$isRoot) {
            $queryCitas->whereIn('consultorio_id', $consultorioIds);
        }

        // Ausentismo por consultorio
        $ausentismoData = (clone $queryCitas)
            ->select(
                'consultorio_id',
                DB::raw('count(*) as total'),
                DB::raw('sum(case when estado_cita = "No Asistió" then 1 else 0 end) as ausentes')
            )
            ->groupBy('consultorio_id')
            ->with('consultorio')
            ->get();

        // Productividad por médico
        $productividadMedicos = (clone $queryCitas)
            ->select(
                'medico_id',
                DB::raw('count(*) as total'),
                DB::raw('sum(case when estado_cita = "Completada" then 1 else 0 end) as atendidas')
            )
            ->groupBy('medico_id')
            ->with(['medico.usuario', 'medico.especialidades'])
            ->get();

        return view('admin.reportes.operatividad', compact('ausentismoData', 'productividadMedicos', 'startDate', 'endDate', 'isRoot'));
    }

    public function financiero(Request $request)
    {
        $filters = $this->getBaseQueryFilters($request);
        $data = $this->getReportData('financiero', $filters, $request);

        return view('admin.reportes.financiero', array_merge($filters, $data));
    }

    public function clinico(Request $request)
    {
        $filters = $this->getBaseQueryFilters($request);
        $data = $this->getReportData('clinico', $filters, $request);

        return view('admin.reportes.clinico', array_merge($filters, $data));
    }

    public function export(Request $request, $type)
    {
        $filters = $this->getBaseQueryFilters($request);
        $reportType = $request->input('report', 'operatividad'); // operatividad, financiero, clinico

        if ($type === 'pdf') {
            return $this->exportPdf($reportType, $filters, $request);
        } elseif ($type === 'excel') {
            return $this->exportExcel($reportType, $filters, $request);
        }

        return back()->with('error', 'Tipo de exportación no válido.');
    }

    private function exportPdf($reportType, $filters, $request)
    {
        $data = $this->getReportData($reportType, $filters, $request);

        $pdf = Pdf::loadView('admin.reportes.exports.pdf', [
            'reportType' => $reportType,
            'data' => $data,
            'filters' => $filters
        ]);

        $filename = 'reporte_' . $reportType . '_' . date('Y-m-d_H-i') . '.pdf';
        return $pdf->download($filename);
    }

    private function exportExcel($reportType, $filters, $request)
    {
        // Por ahora retornamos un CSV simple ya que Laravel Excel requiere clases Export
        $data = $this->getReportData($reportType, $filters, $request);

        $filename = 'reporte_' . $reportType . '_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($data, $reportType) {
            $file = fopen('php://output', 'w');

            // Headers según tipo de reporte
            if ($reportType === 'operatividad') {
                fputcsv($file, ['Médico', 'Citas Totales', 'Atendidas', 'Eficiencia']);
                foreach ($data['productividadMedicos'] ?? [] as $medico) {
                    fputcsv($file, [
                        $medico->medico->nombre_completo ?? 'N/A',
                        $medico->total,
                        $medico->atendidas,
                        round(($medico->atendidas / max(1, $medico->total)) * 100, 1) . '%'
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getReportData($reportType, $filters, $request)
    {
        switch ($reportType) {
            case 'operatividad':
                return [
                    'productividadMedicos' => $this->getProductividadMedicos($filters),
                    'ausentismoData' => $this->getAusentismoData($filters)
                ];
            case 'financiero':
                return [
                    'metodosPago' => $this->getMetodosPago($filters),
                    'ingresosConsultorio' => $this->getIngresosConsultorio($filters),
                    'cuentasPorCobrarList' => $this->getCuentasPorCobrarList($filters),
                    'cuentasPorCobrar' => $this->getCuentasPorCobrarTotal($filters),
                    'totalFacturas' => $this->getTotalFacturasCount($filters),
                    'ticketPromedio' => $this->getTicketPromedio($filters),
                    'ingresosTotal' => $this->getTotalIngresos($filters)
                ];
            case 'clinico':
                return [
                    'topDiagnosticos' => $this->getTopDiagnosticos($filters),
                    'demografiaGenero' => $this->getDemografiaGenero($filters),
                    'demografiaEdad' => $this->getDemografiaEdad($filters),
                    'procedenciaGeografica' => $this->getProcedenciaGeografica($filters)
                ];
            default:
                return [];
        }
    }

    private function getProductividadMedicos($filters)
    {
        $queryCitas = Cita::whereBetween('fecha_cita', [$filters['startDate'], $filters['endDate']]);

        // Filtro unificado
        if (!empty($filters['request_consultorio_id'])) {
            $queryCitas->where('consultorio_id', $filters['request_consultorio_id']);
        } elseif (!empty($filters['request_ciudad_id'])) {
            $cityConsultorios = Consultorio::where('ciudad_id', $filters['request_ciudad_id'])->pluck('id');
            $queryCitas->whereIn('consultorio_id', $cityConsultorios);
        } elseif (!$filters['isRoot']) {
            $queryCitas->whereIn('consultorio_id', $filters['consultorioIds']);
        }

        return $queryCitas
            ->has('medico')
            ->select(
                'medico_id',
                DB::raw('count(*) as total'),
                DB::raw('sum(case when estado_cita = "Completada" then 1 else 0 end) as atendidas')
            )
            ->groupBy('medico_id')
            ->with(['medico.usuario', 'medico.especialidades'])
            ->get();
    }

    private function getAusentismoData($filters)
    {
        $queryCitas = Cita::whereBetween('fecha_cita', [$filters['startDate'], $filters['endDate']]);

        // Filtro unificado
        if (!empty($filters['request_consultorio_id'])) {
            $queryCitas->where('consultorio_id', $filters['request_consultorio_id']);
        } elseif (!empty($filters['request_ciudad_id'])) {
            $cityConsultorios = Consultorio::where('ciudad_id', $filters['request_ciudad_id'])->pluck('id');
            $queryCitas->whereIn('consultorio_id', $cityConsultorios);
        } elseif (!$filters['isRoot']) {
            $queryCitas->whereIn('consultorio_id', $filters['consultorioIds']);
        }

        return $queryCitas
            ->select(
                'consultorio_id',
                DB::raw('count(*) as total'),
                DB::raw('sum(case when estado_cita = "No Asistió" then 1 else 0 end) as ausentes')
            )
            ->groupBy('consultorio_id')
            ->with('consultorio')
            ->get();
    }

    private function getMetodosPago($filters)
    {
        $queryPagos = Pago::whereBetween('fecha_pago', [$filters['startDate'], $filters['endDate']])
            ->where('pago.status', 1);

        if (!empty($filters['request_consultorio_id'])) {
            $queryPagos->whereHas('facturaPaciente.cita', function ($q) use ($filters) {
                $q->where('consultorio_id', $filters['request_consultorio_id']);
            });
        } elseif (!empty($filters['request_ciudad_id'])) {
            $cityConsultorios = Consultorio::where('ciudad_id', $filters['request_ciudad_id'])->pluck('id');
            $queryPagos->whereHas('facturaPaciente.cita', function ($q) use ($cityConsultorios) {
                $q->whereIn('consultorio_id', $cityConsultorios);
            });
        } elseif (!$filters['isRoot']) {
            $queryPagos->whereHas('facturaPaciente.cita', function ($q) use ($filters) {
                $q->whereIn('consultorio_id', $filters['consultorioIds']);
            });
        }

        return $queryPagos
            ->join('metodo_pago', 'pago.id_metodo', '=', 'metodo_pago.id_metodo')
            ->select('metodo_pago.nombre as metodo_pago', DB::raw('sum(pago.monto_equivalente_usd) as total'))
            ->groupBy('metodo_pago.id_metodo', 'metodo_pago.nombre')
            ->get();
    }

    private function getIngresosConsultorio($filters)
    {
        $queryFacturas = FacturaPaciente::whereBetween('fecha_emision', [$filters['startDate'], $filters['endDate']]);
        $this->applyFilters($queryFacturas, $filters, 'facturaPaciente');

        return $queryFacturas
            ->join('citas', 'facturas_pacientes.cita_id', '=', 'citas.id')
            ->join('consultorios', 'citas.consultorio_id', '=', 'consultorios.id')
            ->select('consultorios.id', 'consultorios.nombre', DB::raw('sum(facturas_pacientes.monto_usd) as total'))
            ->groupBy('consultorios.id', 'consultorios.nombre')
            ->get();
    }

    private function getCuentasPorCobrarList($filters)
    {
        $queryFacturas = FacturaPaciente::where('status', 'Pendiente')
            ->whereBetween('fecha_emision', [$filters['startDate'], $filters['endDate']]);

        $this->applyFilters($queryFacturas, $filters, 'facturaPaciente');

        return $queryFacturas->with(['paciente', 'cita.consultorio'])->get();
    }

    private function getTicketPromedio($filters)
    {
        $queryFacturas = FacturaPaciente::whereBetween('fecha_emision', [$filters['startDate'], $filters['endDate']]);
        $this->applyFilters($queryFacturas, $filters, 'facturaPaciente');

        $totalIngresos = (clone $queryFacturas)->sum('monto_usd');
        $totalFacturas = (clone $queryFacturas)->count();

        return $totalFacturas > 0 ? $totalIngresos / $totalFacturas : 0;
    }

    private function applyFilters($query, $filters, $relationType = 'cita')
    {
        // Helper para no repetir lógica
        if (!empty($filters['request_consultorio_id'])) {
            if ($relationType === 'cita') {
                $query->where('consultorio_id', $filters['request_consultorio_id']);
            } else {
                $query->whereHas('cita', function ($q) use ($filters) {
                    $q->where('consultorio_id', $filters['request_consultorio_id']);
                });
            }
        } elseif (!empty($filters['request_ciudad_id'])) {
            $cityConsultorios = Consultorio::where('ciudad_id', $filters['request_ciudad_id'])->pluck('id');
            if ($relationType === 'cita') {
                $query->whereIn('consultorio_id', $cityConsultorios);
            } else {
                $query->whereHas('cita', function ($q) use ($cityConsultorios) {
                    $q->whereIn('consultorio_id', $cityConsultorios);
                });
            }
        } elseif (!$filters['isRoot']) {
            if ($relationType === 'cita') {
                $query->whereIn('consultorio_id', $filters['consultorioIds']);
            } else {
                $query->whereHas('cita', function ($q) use ($filters) {
                    $q->whereIn('consultorio_id', $filters['consultorioIds']);
                });
            }
        }
    }

    private function getTopDiagnosticos($filters)
    {
        $queryEvoluciones = EvolucionClinica::whereBetween('evolucion_clinica.created_at', [$filters['startDate'], $filters['endDate']]);

        if (!empty($filters['request_consultorio_id'])) {
            $queryEvoluciones->whereHas('cita', function ($q) use ($filters) {
                $q->where('consultorio_id', $filters['request_consultorio_id']);
            });
        } elseif (!empty($filters['request_ciudad_id'])) {
            $cityConsultorios = Consultorio::where('ciudad_id', $filters['request_ciudad_id'])->pluck('id');
            $queryEvoluciones->whereHas('cita', function ($q) use ($cityConsultorios) {
                $q->whereIn('consultorio_id', $cityConsultorios);
            });
        } elseif (!$filters['isRoot']) {
            $queryEvoluciones->whereHas('cita', function ($q) use ($filters) {
                $q->whereIn('consultorio_id', $filters['consultorioIds']);
            });
        }

        return $queryEvoluciones
            ->select('diagnostico', DB::raw('count(*) as total'))
            ->groupBy('diagnostico')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();
    }

    private function getDemografiaGenero($filters)
    {
        $queryEvoluciones = EvolucionClinica::whereBetween('evolucion_clinica.created_at', [$filters['startDate'], $filters['endDate']]);
        $this->applyFilters($queryEvoluciones, $filters, 'evolucionClinica'); // Uses same relations as Factura->Cita essentially

        return $queryEvoluciones
            ->join('pacientes', 'evolucion_clinica.paciente_id', '=', 'pacientes.id')
            ->select('pacientes.genero', DB::raw('count(distinct pacientes.id) as total'))
            ->whereIn('pacientes.genero', ['Masculino', 'Femenino'])
            ->groupBy('pacientes.genero')
            ->get();
    }

    private function getDemografiaEdad($filters)
    {
        $queryEvoluciones = EvolucionClinica::whereBetween('evolucion_clinica.created_at', [$filters['startDate'], $filters['endDate']]);
        $this->applyFilters($queryEvoluciones, $filters, 'evolucionClinica');

        // Get unique patients and their birth dates
        $pacientes = $queryEvoluciones->with('paciente:id,fecha_nac')
            ->get()
            ->pluck('paciente')
            ->unique('id');

        // Group by age ranges manually to work across DB types
        $ranges = [
            '0-10' => 0,
            '11-20' => 0,
            '21-30' => 0,
            '31-40' => 0,
            '41-50' => 0,
            '51-60' => 0,
            '60+' => 0
        ];

        foreach ($pacientes as $paciente) {
            if (!$paciente || !$paciente->fecha_nac)
                continue;

            $age = Carbon::parse($paciente->fecha_nac)->age;

            if ($age <= 10)
                $ranges['0-10']++;
            elseif ($age <= 20)
                $ranges['11-20']++;
            elseif ($age <= 30)
                $ranges['21-30']++;
            elseif ($age <= 40)
                $ranges['31-40']++;
            elseif ($age <= 50)
                $ranges['41-50']++;
            elseif ($age <= 60)
                $ranges['51-60']++;
            else
                $ranges['60+']++;
        }

        return $ranges;
    }

    private function getProcedenciaGeografica($filters)
    {
        $queryEvoluciones = EvolucionClinica::whereBetween('evolucion_clinica.created_at', [$filters['startDate'], $filters['endDate']]);
        $this->applyFilters($queryEvoluciones, $filters, 'evolucionClinica');

        return $queryEvoluciones
            ->join('pacientes', 'evolucion_clinica.paciente_id', '=', 'pacientes.id')
            ->join('ciudades', 'pacientes.ciudad_id', '=', 'ciudades.id_ciudad') // Assuming id_ciudad based on previous task
            ->join('estados', 'pacientes.estado_id', '=', 'estados.id_estado')
            ->select(
                'estados.estado',
                'ciudades.ciudad',
                DB::raw('count(distinct pacientes.id) as total')
            )
            ->groupBy('estados.estado', 'ciudades.ciudad')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();
    }
    private function getTotalIngresos($filters)
    {
        $queryFacturas = FacturaPaciente::whereBetween('fecha_emision', [$filters['startDate'], $filters['endDate']]);
        $this->applyFilters($queryFacturas, $filters, 'facturaPaciente');
        return $queryFacturas->sum('monto_usd');
    }

    private function getCuentasPorCobrarTotal($filters)
    {
        $queryFacturas = FacturaPaciente::where('status', 'Pendiente')
            ->whereBetween('fecha_emision', [$filters['startDate'], $filters['endDate']]);
        $this->applyFilters($queryFacturas, $filters, 'facturaPaciente');
        return $queryFacturas->sum('monto_usd');
    }

    private function getTotalFacturasCount($filters)
    {
        $queryFacturas = FacturaPaciente::whereBetween('fecha_emision', [$filters['startDate'], $filters['endDate']]);
        $this->applyFilters($queryFacturas, $filters, 'facturaPaciente');
        return $queryFacturas->count();
    }
}
