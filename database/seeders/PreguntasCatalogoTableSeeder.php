<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PreguntasCatalogoTableSeeder extends Seeder
{
    public function run(): void
    {
        $preguntas = [
            '¿Cuál es el nombre de tu primera mascota?',
            '¿En qué ciudad naciste?',
            '¿Cuál es tu comida favorita?',
            '¿Cuál es el nombre de tu mejor amigo de la infancia?',
            '¿Cuál es el nombre de soltera de tu madre?',
            '¿En qué escuela estudiaste la primaria?',
            '¿Cuál es tu color favorito?',
            '¿Cuál es el nombre de tu película favorita?',
            '¿Cuál fue tu primer trabajo?',
            '¿Cuál es tu equipo deportivo favorito?',
            '¿Cuál es el nombre de tu abuelo paterno?',
            '¿En qué año te graduaste de bachillerato?',
            '¿Cuál es tu libro favorito?',
            '¿Cuál es el nombre de tu primer profesor?',
            '¿Cuál es tu lugar de vacaciones favorito?',
        ];

        foreach ($preguntas as $pregunta) {
            DB::table('preguntas_catalogo')->insert([
                'pregunta' => $pregunta,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
