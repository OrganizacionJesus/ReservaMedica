<?php

use Illuminate\Database\Seeder;
use App\Models\DatosPagoMedico;
use App\Models\Medico;

class DatosPagoMedicoSeeder extends Seeder
{
    public function run(): void
    {
        $medicos = Medico::all();
        
        foreach ($medicos as $medico) {
            // Crear datos de pago para cada médico con datos de ejemplo
            DatosPagoMedico::updateOrCreate(
                ['medico_id' => $medico->id],
                [
                    // Datos de transferencia bancaria
                    'banco_nombre' => 'Banco Nacional de Crédito',
                    'cuenta_tipo' => 'Ahorro',
                    'cuenta_numero' => '0134-0001-234567890',
                    'titular_cuenta' => $medico->nombre_completo,
                    'cedula_titular' => $medico->cedula,
                    
                    // Datos de pago móvil
                    'pm_operadora' => 'Movilnet',
                    'pm_numero' => '0414-1234567',
                    'pm_cedula' => $medico->cedula,
                    
                    // Métodos habilitados
                    'metodos_habilitados' => ['transferencia', 'pago_movil', 'efectivo'],
                    'metodo_preferido' => 'transferencia',
                    
                    // Estado
                    'activo' => true,
                    'verificado' => false,
                    'fecha_verificacion' => null,
                    'notas_internas' => 'Datos generados automáticamente - requieren verificación'
                ]
            );
        }

        $this->command->info('Datos de pago de médicos creados exitosamente');
    }
}
