<?php

namespace App\Services;

use App\Models\Liquidacion;
use App\Models\LiquidacionDetalle;
use App\Models\FacturaTotal;
use App\Models\Medico;
use App\Models\Consultorio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class LiquidacionService
{
    /**
     * Generar liquidación para un período específico
     */
    public function generarLiquidacionPorPeriodo(
        string $entidadTipo,
        int $entidadId,
        string $tipoPeriodo,
        Carbon $fechaInicio,
        Carbon $fechaFin,
        array $datosPago
    ): Liquidacion {
        DB::beginTransaction();
        
        try {
            // Validar que no exista liquidación duplicada  para este período
            $existente = Liquidacion::where('entidad_tipo', $entidadTipo)
                ->where('entidad_id', $entidadId)
                ->where('periodo_tipo', $tipoPeriodo)
                ->where('fecha_inicio_periodo', $fechaInicio)
                ->where('fecha_fin_periodo', $fechaFin)
                ->exists();
            
            if ($existente) {
                throw new \Exception('Ya existe una liquidación para este período');
            }
            
            // Obtener facturas pendientes del período
            $facturasPendientes = $this->obtenerFacturasPendientesPorPeriodo(
                $entidadTipo,
                $entidadId,
                $fechaInicio,
                $fechaFin
            );
            
            if ($facturasPendientes->isEmpty()) {
                throw new \Exception('No hay facturas pendientes de liquidación para este período');
            }
            
            // Calcular totales
            $totalUSD = $facturasPendientes->sum('total_final_usd');
            $totalBS = $facturasPendientes->sum('total_final_bs');
            
            // Crear liquidación
            $liquidacion = Liquidacion::create([
                'entidad_tipo' => $entidadTipo,
                'entidad_id' => $entidadId,
                'periodo_tipo' => $tipoPeriodo,
                'fecha_inicio_periodo' => $fechaInicio,
                'fecha_fin_periodo' => $fechaFin,
                'monto_total_usd' => $totalUSD,
                'monto_total_bs' => $totalBS,
                'metodo_pago' => $datosPago['metodo_pago'],
                'referencia' => $datosPago['referencia'],
                'fecha_pago' => $datosPago['fecha_pago'],
                'observaciones' => $datosPago['observaciones'] ?? null,
                'status' => true
            ]);
            
            // Vincular facturas a la liquidación
            $this->vincularFacturasALiquidacion($liquidacion, $facturasPendientes);
            
            DB::commit();
            return $liquidacion;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error generando liquidación: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Calcular períodos quincenales para un mes
     */
    public function calcularPeriodosQuincenales(int $anio, int $mes): array
    {
        $primerDia = Carbon::create($anio, $mes, 1)->startOfDay();
        $ultimoDia = $primerDia->copy()->endOfMonth()->endOfDay();
        
        // Primera quincena: día 1 al 15
        $finPrimeraQuincena = Carbon::create($anio, $mes, 15)->endOfDay();
        
        // Segunda quincena: día 16 al último día del mes
        $inicioSegundaQuincena = Carbon::create($anio, $mes, 16)->startOfDay();
        
        return [
            'primera_quincena' => [
                'inicio' => $primerDia,
                'fin' => $finPrimeraQuincena
            ],
            'segunda_quincena' => [
                'inicio' => $inicioSegundaQuincena,
                'fin' => $ultimoDia
            ]
        ];
    }
    
    /**
     * Obtener totales pendientes de liquidación
     */
    public function obtenerTotalesPendientes(
        string $entidadTipo,
        ?int $entidadId = null,
        ?Carbon $fechaInicio = null,
        ?Carbon $fechaFin = null
    ): Collection {
        $query = FacturaTotal::with(['facturaCabecera.cita'])
            ->where('entidad_tipo', $entidadTipo)
            ->where('estado_liquidacion', 'Pendiente')
            ->where('status', true);
        
        if ($entidadId) {
            $query->where('entidad_id', $entidadId);
        }
        
        if ($fechaInicio && $fechaFin) {
            $query->whereHas('facturaCabecera', function($q) use ($fechaInicio, $fechaFin) {
                $q->whereBetween('fecha_emision', [$fechaInicio, $fechaFin]);
            });
        }
        
        return $query->get();
    }
    
    /**
     * Obtener facturas pendientes de un período
     */
    private function obtenerFacturasPendientesPorPeriodo(
        string $entidadTipo,
        int $entidadId,
        Carbon $fechaInicio,
        Carbon $fechaFin
    ): Collection {
        return FacturaTotal::where('entidad_tipo', $entidadTipo)
            ->where('entidad_id', $entidadId)
            ->where('estado_liquidacion', 'Pendiente')
            ->where('status', true)
            ->whereHas('facturaCabecera', function($q) use ($fechaInicio, $fechaFin) {
                $q->whereBetween('fecha_emision', [$fechaInicio, $fechaFin]);
            })
            ->with('facturaCabecera')
            ->get();
    }
    
    /**
     * Vincular facturas a una liquidación
     */
    private function vincularFacturasALiquidacion(Liquidacion $liquidacion, Collection $facturas): void
    {
        foreach ($facturas as $factura) {
            // Crear detalle de liquidación
            LiquidacionDetalle::create([
                'liquidacion_id' => $liquidacion->id,
                'factura_total_id' => $factura->id,
                'monto_usd' => $factura->total_final_usd,
                'monto_bs' => $factura->total_final_bs,
                'status' => true
            ]);
            
            // Marcar factura como liquidada
            $factura->update(['estado_liquidacion' => 'Liquidado']);
        }
    }
    
    /**
     * Obtener resumen de liquidaciones por entidad
     */
    public function obtenerResumenLiquidaciones(
        string $entidadTipo,
        int $entidadId,
        ?Carbon $fechaDesde = null,
        ?Carbon $fechaHasta = null
    ): array {
        $query = Liquidacion::where('entidad_tipo', $entidadTipo)
            ->where('entidad_id', $entidadId)
            ->where('status', true);
        
        if ($fechaDesde) {
            $query->where('fecha_pago', '>=', $fechaDesde);
        }
        
        if ($fechaHasta) {
            $query->where('fecha_pago', '<=', $fechaHasta);
        }
        
        $liquidaciones = $query->with('detalles.facturaTotal')->get();
        
        $totalLiquidadoUSD = $liquidaciones->sum('monto_total_usd');
        $totalLiquidadoBS = $liquidaciones->sum('monto_total_bs');
        
        // Obtener pendientes
        $pendientes = $this->obtenerTotalesPendientes($entidadTipo, $entidadId);
        $totalPendienteUSD = $pendientes->sum('total_final_usd');
        $totalPendienteBS = $pendientes->sum('total_final_bs');
        
        return [
            'liquidaciones' => $liquidaciones,
            'total_liquidado_usd' => $totalLiquidadoUSD,
            'total_liquidado_bs' => $totalLiquidadoBS,
            'total_pendiente_usd' => $totalPendienteUSD,
            'total_pendiente_bs' => $totalPendienteBS,
            'cantidad_liquidaciones' => $liquidaciones->count(),
            'cantidad_pendientes' => $pendientes->count()
        ];
    }
}
