<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PreguntasCatalogoTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('preguntas_catalogo')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $preguntas = [
            ['pregunta' => '¿Cuál es el nombre de tu primera mascota?'],
            ['pregunta' => '¿En qué ciudad naciste?'],
            ['pregunta' => '¿Cuál es tu color favorito?'],
            ['pregunta' => '¿Nombre de tu escuela primaria?'],
            ['pregunta' => '¿Cuál es tu comida favorita?'],
        ];

        foreach ($preguntas as $pregunta) {
            DB::table('preguntas_catalogo')->insert(array_merge($pregunta, [
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
