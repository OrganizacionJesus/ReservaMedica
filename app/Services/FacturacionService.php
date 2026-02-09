<?php

namespace App\Services;

use App\Models\Cita;
use App\Models\FacturaCabecera;
use App\Models\FacturaDetalle;
use App\Models\FacturaPaciente;
use App\Models\FacturaTotal;
use App\Models\ConfiguracionReparto;
use App\Models\TasaDolar;
use App\Models\Configuracion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FacturacionService
{
    /**
     * Ejecutar facturación avanzada con reparto de porcentajes
     */
    public function ejecutarFacturacionAvanzada(Cita $cita): FacturaCabecera
    {
        // Verificar si ya existe facturación avanzada para esta cita
        if ($cita->facturaCabecera) {
            return $cita->facturaCabecera;
        }

        DB::beginTransaction();
        
        try {
            $facturaPaciente = $cita->facturaPaciente;
            if (!$facturaPaciente) {
                // Si no existe factura paciente (ej. cita gratuita o caso borde), 
                // intentamos buscar una creada o lanzar error según lógica de negocio.
                // Por ahora asumimos que DEBE existir.
                throw new \Exception('La cita no tiene factura de paciente asociada para procesar el reparto.');
            }
            
            $tasa = $this->obtenerTasa($facturaPaciente); 
            $facturaCabecera = $this->crearCabecera($cita, $tasa);
            $configReparto = $this->obtenerConfiguracionReparto($cita);
            
            $this->crearDetalles($facturaCabecera, $cita, $configReparto);
            $this->crearTotales($facturaCabecera, $tasa);
            
            DB::commit();
            return $facturaCabecera;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en facturación avanzada: ' . $e->getMessage());
            throw $e;
        }
    }
    
    private function obtenerTasa(FacturaPaciente $facturaPaciente): TasaDolar
    {
        $tasa = $facturaPaciente->tasa;
        if (!$tasa) {
            $tasa = TasaDolar::where('status', true)->orderBy('fecha_tasa', 'desc')->first();
        }
        
        if (!$tasa) {
            throw new \Exception('No se encontró tasa de cambio para facturación avanzada');
        }
        
        return $tasa;
    }

    private function crearCabecera(Cita $cita, TasaDolar $tasa): FacturaCabecera
    {
        return FacturaCabecera::create([
            'cita_id' => $cita->id,
            'nro_control' => $this->generarNumeroControl(),
            'paciente_id' => $cita->paciente_id,
            'medico_id' => $cita->medico_id,
            'tasa_id' => $tasa->id,
            'fecha_emision' => now(),
            'status' => true
        ]);
    }
    
    private function obtenerConfiguracionReparto(Cita $cita): object
    {
        // 1. Buscar configuración específica Médico + Consultorio
        $config = ConfiguracionReparto::where('medico_id', $cita->medico_id)
            ->where('consultorio_id', $cita->consultorio_id)
            ->first();
        
        // 2. Buscar configuración solo Médico (sin consultorio o consultorio nulo)
        if (!$config) {
            $config = ConfiguracionReparto::where('medico_id', $cita->medico_id)
                ->whereNull('consultorio_id')
                ->first();
        }
        
        // 3. Si no existe, usar configuración global o por defecto
        if (!$config) {
            return $this->obtenerConfiguracionPorDefecto();
        }
        
        return $config;
    }
    
    private function obtenerConfiguracionPorDefecto(): object
    {
        // Intentar leer de la tabla de configuraciones globales
        // Asumiendo que existen keys: 'reparto_porcentaje_medico', etc.
        $config = Configuracion::whereIn('key', [
            'reparto_porcentaje_medico',
            'reparto_porcentaje_consultorio',
            'reparto_porcentaje_sistema'
        ])->pluck('value', 'key');
        
        $obj = new \stdClass();
        
        if ($config->isEmpty()) {
            // Valores fallback hardcoded si no hay configuración en BD
            $obj->porcentaje_medico = 70.00;
            $obj->porcentaje_consultorio = 20.00;
            $obj->porcentaje_sistema = 10.00;
        } else {
            $obj->porcentaje_medico = $config['reparto_porcentaje_medico'] ?? 70.00;
            $obj->porcentaje_consultorio = $config['reparto_porcentaje_consultorio'] ?? 20.00;
            $obj->porcentaje_sistema = $config['reparto_porcentaje_sistema'] ?? 10.00;
        }
        
        return $obj;
    }

    private function generarNumeroControl(): string
    {
        $year = date('Y');
        $sequence = FacturaCabecera::whereYear('fecha_emision', $year)->count() + 1;
        return 'FACT-' . $year . '-' . str_pad($sequence, 6, '0', STR_PAD_LEFT);
    }

    private function crearDetalles(FacturaCabecera $facturaCabecera, Cita $cita, object $configReparto): void
    {
        // Calcular tarifa base + extra si aplica
        $tarifaUSD = ($cita->tarifa ?? 0) + ($cita->tarifa_extra ?? 0);

        // 1. Detalle para el Médico
        FacturaDetalle::create([
            'cabecera_id' => $facturaCabecera->id,
            'entidad_tipo' => 'Medico',
            'entidad_id' => $cita->medico_id,
            'descripcion' => 'Honorarios médicos (' . $configReparto->porcentaje_medico . '%)',
            'cantidad' => 1,
            'precio_unitario_usd' => $tarifaUSD * ($configReparto->porcentaje_medico / 100),
            'subtotal_usd' => $tarifaUSD * ($configReparto->porcentaje_medico / 100),
            'status' => true
        ]);

        // 2. Detalle para el Consultorio (si aplica y porcentaje > 0)
        if ($cita->consultorio_id && $configReparto->porcentaje_consultorio > 0) {
            FacturaDetalle::create([
                'cabecera_id' => $facturaCabecera->id,
                'entidad_tipo' => 'Consultorio',
                'entidad_id' => $cita->consultorio_id,
                'descripcion' => 'Uso de consultorio (' . $configReparto->porcentaje_consultorio . '%)',
                'cantidad' => 1,
                'precio_unitario_usd' => $tarifaUSD * ($configReparto->porcentaje_consultorio / 100),
                'subtotal_usd' => $tarifaUSD * ($configReparto->porcentaje_consultorio / 100),
                'status' => true
            ]);
        }

        // 3. Detalle para el Sistema (si porcentaje > 0)
        if ($configReparto->porcentaje_sistema > 0) {
            FacturaDetalle::create([
                'cabecera_id' => $facturaCabecera->id,
                'entidad_tipo' => 'Sistema',
                'entidad_id' => null, // Sistema no tiene ID de entidad específico en tablas de negocio
                'descripcion' => 'Comisión del sistema (' . $configReparto->porcentaje_sistema . '%)',
                'cantidad' => 1,
                'precio_unitario_usd' => $tarifaUSD * ($configReparto->porcentaje_sistema / 100),
                'subtotal_usd' => $tarifaUSD * ($configReparto->porcentaje_sistema / 100),
                'status' => true
            ]);
        }
    }

    private function crearTotales(FacturaCabecera $facturaCabecera, TasaDolar $tasa): void
    {
        $detalles = $facturaCabecera->detalles;

        foreach ($detalles as $detalle) {
            $baseImponibleUSD = $detalle->subtotal_usd;
            $totalFinalUSD = $baseImponibleUSD; // Asumiendo sin impuestos por ahora
            $totalFinalBS = $totalFinalUSD * $tasa->valor;

            FacturaTotal::create([
                'cabecera_id' => $facturaCabecera->id,
                'entidad_tipo' => $detalle->entidad_tipo,
                'entidad_id' => $detalle->entidad_id,
                'base_imponible_usd' => $baseImponibleUSD,
                'impuestos_usd' => 0,
                'total_final_usd' => $totalFinalUSD,
                'total_final_bs' => $totalFinalBS,
                'estado_liquidacion' => 'Pendiente',
                'status' => true
            ]);
        }
    }
}
