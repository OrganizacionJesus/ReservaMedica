<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class MedicoEspecialidadTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $relaciones = [];

        // Asegurar asignaciones fijas para médicos 1 y 2
        $relaciones[] = ['medico_id' => 1, 'especialidad_id' => 1, 'tarifa' => 50.00, 'anos_experiencia' => 15]; // Cardiología
        $relaciones[] = ['medico_id' => 1, 'especialidad_id' => 7, 'tarifa' => 30.00, 'anos_experiencia' => 15]; // Medicina General
        $relaciones[] = ['medico_id' => 2, 'especialidad_id' => 2, 'tarifa' => 45.00, 'anos_experiencia' => 10]; // Pediatría

        // Para los médicos del 3 al 12 (Generados)
        for ($medicoId = 3; $medicoId <= 12; $medicoId++) {
            // Asignar entre 1 y 2 especialidades por médico
            $numEspecialidades = $faker->numberBetween(1, 2);
            $especialidadesIds = $faker->randomElements(range(1, 20), $numEspecialidades);

            foreach ($especialidadesIds as $espId) {
                // Verificar que no se repita (aunque aquí son elementos únicos por randomElements)
                $relaciones[] = [
                    'medico_id' => $medicoId,
                    'especialidad_id' => $espId,
                    'tarifa' => $faker->randomFloat(2, 20, 100), // Tarifas entre 20 y 100
                    'anos_experiencia' => $faker->numberBetween(1, 30),
                ];
            }
        }
        // Médico 1 (ID 5) - Cardiología (ID 1)
        $relaciones[] = [
            'medico_id' => 5,
            'especialidad_id' => 1,
            'tarifa' => 50.00,
            'anos_experiencia' => 15
        ];

        // Médico 1 (ID 5) - Medicina General (ID 7) - Segunda especialidad
        $relaciones[] = [
            'medico_id' => 5,
            'especialidad_id' => 7,
            'tarifa' => 30.00,
            'anos_experiencia' => 18
        ];

        // Médico 2 (ID 6) - Pediatría (ID 2)
        $relaciones[] = [
            'medico_id' => 6,
            'especialidad_id' => 2,
            'tarifa' => 45.00,
            'anos_experiencia' => 10
        ];

        // Médico 3 (ID 7) - Traumatología (ID 5)
        $relaciones[] = [
            'medico_id' => 7,
            'especialidad_id' => 5,
            'tarifa' => 60.00,
            'anos_experiencia' => 12
        ];

        foreach ($relaciones as $relacion) {
            DB::table('medico_especialidad')->updateOrInsert(
                ['medico_id' => $relacion['medico_id'], 'especialidad_id' => $relacion['especialidad_id']],
                array_merge($relacion, [
                    'status' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ])
            );
        }
    }
}
