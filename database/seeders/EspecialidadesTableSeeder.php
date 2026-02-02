<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspecialidadesTableSeeder extends Seeder
{
    public function run(): void
    {
        $especialidades = [
            [
                'nombre' => 'Medicina General',
                'descripcion' => 'Atención médica integral para diagnóstico y tratamiento de enfermedades comunes',
            ],
            [
                'nombre' => 'Cardiología',
                'descripcion' => 'Especialidad enfocada en el diagnóstico y tratamiento de enfermedades del corazón y sistema cardiovascular',
            ],
            [
                'nombre' => 'Pediatría',
                'descripcion' => 'Atención médica especializada para bebés, niños y adolescentes',
            ],
            [
                'nombre' => 'Ginecología y Obstetricia',
                'descripcion' => 'Atención de la salud reproductiva femenina, embarazo y parto',
            ],
            [
                'nombre' => 'Traumatología y Ortopedia',
                'descripcion' => 'Tratamiento de lesiones y enfermedades del sistema musculoesquelético',
            ],
            [
                'nombre' => 'Dermatología',
                'descripcion' => 'Diagnóstico y tratamiento de enfermedades de la piel, cabello y uñas',
            ],
            [
                'nombre' => 'Oftalmología',
                'descripcion' => 'Especialidad médica dedicada al cuidado de los ojos y la visión',
            ],
            [
                'nombre' => 'Otorrinolaringología',
                'descripcion' => 'Tratamiento de enfermedades de oído, nariz y garganta',
            ],
            [
                'nombre' => 'Neurología',
                'descripcion' => 'Diagnóstico y tratamiento de enfermedades del sistema nervioso',
            ],
            [
                'nombre' => 'Psiquiatría',
                'descripcion' => 'Atención de trastornos mentales y emocionales',
            ],
            [
                'nombre' => 'Endocrinología',
                'descripcion' => 'Tratamiento de enfermedades hormonales y metabólicas',
            ],
            [
                'nombre' => 'Gastroenterología',
                'descripcion' => 'Especialidad enfocada en el sistema digestivo y sus trastornos',
            ],
            [
                'nombre' => 'Urología',
                'descripcion' => 'Tratamiento de enfermedades del sistema urinario y reproductor masculino',
            ],
            [
                'nombre' => 'Neumología',
                'descripcion' => 'Diagnóstico y tratamiento de enfermedades respiratorias',
            ],
            [
                'nombre' => 'Nefrología',
                'descripcion' => 'Especialidad dedicada a las enfermedades renales',
            ],
            [
                'nombre' => 'Oncología',
                'descripcion' => 'Diagnóstico y tratamiento del cáncer',
            ],
            [
                'nombre' => 'Medicina Interna',
                'descripcion' => 'Atención integral de adultos con enfermedades complejas o múltiples',
            ],
            [
                'nombre' => 'Cirugía General',
                'descripcion' => 'Procedimientos quirúrgicos para el tratamiento de diversas patologías',
            ],
            [
                'nombre' => 'Reumatología',
                'descripcion' => 'Tratamiento de enfermedades reumáticas y autoinmunes',
            ],
            [
                'nombre' => 'Hematología',
                'descripcion' => 'Especialidad enfocada en enfermedades de la sangre',
            ],
        ];

        foreach ($especialidades as $especialidad) {
            DB::table('especialidades')->insert(array_merge($especialidad, [
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
