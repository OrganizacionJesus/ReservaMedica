<?php

namespace App\Services;

use Carbon\Carbon;

class PeriodoCalculator
{
    /**
     * Calcular períodos quincenales exactos para un mes y año específicos
     */
    public static function calcularQuincenas($year = null, $month = null)
    {
        $year = $year ?? date('Y');
        $month = $month ?? date('m');
        
        $fechaInicio = Carbon::create($year, $month, 1);
        $fechaFin = Carbon::create($year, $month, 1)->endOfMonth();
        
        $periodos = [];
        
        // Primera quincena: Día 1 al 15 (o al fin de mes si febrero)
        $finPrimeraQuincena = min(15, $fechaFin->day);
        
        $periodos[] = [
            'nombre' => 'Primera Quincena',
            'tipo' => 'quincenal',
            'inicio' => $fechaInicio->copy()->format('Y-m-d'),
            'fin' => $fechaInicio->copy()->day($finPrimeraQuincena)->format('Y-m-d'),
            'dias' => $finPrimeraQuincena,
            'mes' => $fechaInicio->format('F'),
            'anio' => $year,
            'numero_quincena' => 1
        ];
        
        // Segunda quincena: Día 16 al último día del mes (solo si el mes tiene más de 15 días)
        if ($fechaFin->day > 15) {
            $periodos[] = [
                'nombre' => 'Segunda Quincena',
                'tipo' => 'quincenal',
                'inicio' => $fechaInicio->copy()->day(16)->format('Y-m-d'),
                'fin' => $fechaFin->format('Y-m-d'),
                'dias' => $fechaFin->day - 15,
                'mes' => $fechaInicio->format('F'),
                'anio' => $year,
                'numero_quincena' => 2
            ];
        }
        
        return $periodos;
    }
    
    /**
     * Calcular período mensual exacto
     */
    public static function calcularMensual($year = null, $month = null)
    {
        $year = $year ?? date('Y');
        $month = $month ?? date('m');
        
        $fechaInicio = Carbon::create($year, $month, 1);
        $fechaFin = $fechaInicio->copy()->endOfMonth();
        
        return [
            'nombre' => $fechaInicio->format('F') . ' ' . $year,
            'tipo' => 'mensual',
            'inicio' => $fechaInicio->format('Y-m-d'),
            'fin' => $fechaFin->format('Y-m-d'),
            'dias' => $fechaFin->day,
            'mes' => $fechaInicio->format('F'),
            'anio' => $year,
            'numero_mes' => (int)$month
        ];
    }
    
    /**
     * Obtener período actual basado en la fecha de hoy
     */
    public static function getPeriodoActual($tipo = 'quincenal')
    {
        $hoy = Carbon::now();
        
        if ($tipo === 'quincenal') {
            $quincenas = self::calcularQuincenas($hoy->year, $hoy->month);
            
            foreach ($quincenas as $quincena) {
                $inicio = Carbon::parse($quincena['inicio']);
                $fin = Carbon::parse($quincena['fin']);
                
                if ($hoy->between($inicio, $fin)) {
                    return $quincena;
                }
            }
        } elseif ($tipo === 'mensual') {
            return self::calcularMensual($hoy->year, $hoy->month);
        }
        
        throw new \Exception("No se pudo determinar el período actual para el tipo: {$tipo}");
    }
    
    /**
     * Obtener períodos anteriores hasta una fecha específica
     */
    public static function getPeriodosAnteriores($tipo = 'quincenal', $cantidad = 6, $hastaFecha = null)
    {
        $hastaFecha = $hastaFecha ? Carbon::parse($hastaFecha) : Carbon::now();
        $periodos = [];
        
        for ($i = 0; $i < $cantidad; $i++) {
            if ($tipo === 'quincenal') {
                // Retroceder quincenas
                $fechaReferencia = $hastaFecha->copy()->subQuincenas($i);
                $quincenas = self::calcularQuincenas($fechaReferencia->year, $fechaReferencia->month);
                
                // Tomar la quincena correspondiente
                if ($fechaReferencia->day <= 15 && isset($quincenas[0])) {
                    $periodos[] = $quincenas[0];
                } elseif (isset($quincenas[1])) {
                    $periodos[] = $quincenas[1];
                }
            } elseif ($tipo === 'mensual') {
                // Retroceder meses
                $fechaReferencia = $hastaFecha->copy()->subMonths($i);
                $periodos[] = self::calcularMensual($fechaReferencia->year, $fechaReferencia->month);
            }
        }
        
        return array_reverse($periodos); // Orden cronológico
    }
    
    /**
     * Validar que dos períodos no se solapen
     */
    public static function validarSinSolapamiento($periodo1, $periodo2)
    {
        $inicio1 = Carbon::parse($periodo1['inicio']);
        $fin1 = Carbon::parse($periodo1['fin']);
        $inicio2 = Carbon::parse($periodo2['inicio']);
        $fin2 = Carbon::parse($periodo2['fin']);
        
        // Si hay solapamiento
        return !($inicio1->lte($fin2) && $fin1->gte($inicio2));
    }
    
    /**
     * Calcular días hábiles en un período (opcional, para cálculos más precisos)
     */
    public static function calcularDiasHabiles($inicio, $fin, $excluirFeriados = true)
    {
        $inicio = Carbon::parse($inicio);
        $fin = Carbon::parse($fin);
        $diasHabiles = 0;
        
        while ($inicio->lte($fin)) {
            // Excluir fines de semana
            if (!$inicio->isWeekend()) {
                // Aquí se podrían excluir feriados si se tiene una tabla de feriados
                $diasHabiles++;
            }
            $inicio->addDay();
        }
        
        return $diasHabiles;
    }
    
    /**
     * Formatear período para visualización
     */
    public static function formatearPeriodo($periodo)
    {
        $inicio = Carbon::parse($periodo['inicio']);
        $fin = Carbon::parse($periodo['fin']);
        
        return [
            'nombre_completo' => $periodo['nombre'] . ' ' . $periodo['anio'],
            'rango_fechas' => $inicio->format('d/m/Y') . ' al ' . $fin->format('d/m/Y'),
            'rango_corto' => $inicio->format('d/m') . ' - ' . $fin->format('d/m/Y'),
            'dias_transcurridos' => $inicio->diffInDays($fin) + 1,
            'esta_vigente' => Carbon::now()->between($inicio, $fin),
            'esta_proximo' => Carbon::now()->lt($inicio) && Carbon::now()->diffInDays($inicio) <= 7,
            'esta_vencido' => Carbon::now()->gt($fin)
        ];
    }
    
    /**
     * Obtener próximo período a liquidar
     */
    public static function getProximoPeriodo($tipo = 'quincenal')
    {
        $hoy = Carbon::now();
        
        if ($tipo === 'quincenal') {
            if ($hoy->day <= 15) {
                // Estamos en la primera quincena, la próxima es la segunda
                return [
                    'inicio' => $hoy->copy()->day(16)->format('Y-m-d'),
                    'fin' => $hoy->copy()->endOfMonth()->format('Y-m-d'),
                    'nombre' => 'Segunda Quincena ' . $hoy->format('F Y')
                ];
            } else {
                // Estamos en la segunda quincena, la próxima es la primera del siguiente mes
                $siguienteMes = $hoy->copy()->addMonth()->startOfMonth();
                return [
                    'inicio' => $siguienteMes->format('Y-m-d'),
                    'fin' => $siguienteMes->day(15)->format('Y-m-d'),
                    'nombre' => 'Primera Quincena ' . $siguienteMes->format('F Y')
                ];
            }
        } elseif ($tipo === 'mensual') {
            $siguienteMes = $hoy->copy()->addMonth()->startOfMonth();
            return [
                'inicio' => $siguienteMes->format('Y-m-d'),
                'fin' => $siguienteMes->endOfMonth()->format('Y-m-d'),
                'nombre' => $siguienteMes->format('F Y')
            ];
        }
        
        throw new \Exception("No se pudo calcular el próximo período para el tipo: {$tipo}");
    }
}
