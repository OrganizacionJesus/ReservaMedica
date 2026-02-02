<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MunicipiosTableSeeder extends Seeder
{
    public function run(): void
    {
        $municipios = [
            // Distrito Capital (id_estado: 10)
            ['municipio' => 'Libertador', 'id_estado' => 10],

            // Miranda (id_estado: 15)
            ['municipio' => 'Guaicaipuro', 'id_estado' => 15],
            ['municipio' => 'Plaza', 'id_estado' => 15],
            ['municipio' => 'Sucre', 'id_estado' => 15],
            ['municipio' => 'Baruta', 'id_estado' => 15],
            ['municipio' => 'Chacao', 'id_estado' => 15],

            // Zulia (id_estado: 24)
            ['municipio' => 'Maracaibo', 'id_estado' => 24],
            ['municipio' => 'San Francisco', 'id_estado' => 24],
            ['municipio' => 'Jesús Enrique Lossada', 'id_estado' => 24],

            // Carabobo (id_estado: 7)
            ['municipio' => 'Valencia', 'id_estado' => 7],
            ['municipio' => 'Naguanagua', 'id_estado' => 7],
            ['municipio' => 'San Diego', 'id_estado' => 7],

            // Lara (id_estado: 13)
            ['municipio' => 'Iribarren', 'id_estado' => 13],
            ['municipio' => 'Palavecino', 'id_estado' => 13],

            // Aragua (id_estado: 4)
            ['municipio' => 'Girardot', 'id_estado' => 4],
            ['municipio' => 'Mario Briceño Iragorry', 'id_estado' => 4],

            // Anzoátegui (id_estado: 2)
            ['municipio' => 'Bolívar', 'id_estado' => 2],
            ['municipio' => 'Sotillo', 'id_estado' => 2],

            // Táchira (id_estado: 20)
            ['municipio' => 'San Cristóbal', 'id_estado' => 20],
            ['municipio' => 'Cárdenas', 'id_estado' => 20],

            // Mérida (id_estado: 14)
            ['municipio' => 'Libertador', 'id_estado' => 14],

            // Bolívar (id_estado: 6)
            ['municipio' => 'Heres', 'id_estado' => 6],
            ['municipio' => 'Caroní', 'id_estado' => 6],

            // Monagas (id_estado: 16)
            ['municipio' => 'Maturín', 'id_estado' => 16],

            // Sucre (id_estado: 19)
            ['municipio' => 'Sucre', 'id_estado' => 19],

            // Portuguesa (id_estado: 18)
            ['municipio' => 'Guanare', 'id_estado' => 18],

            // Barinas (id_estado: 5)
            ['municipio' => 'Barinas', 'id_estado' => 5],

            // Falcón (id_estado: 11)
            ['municipio' => 'Miranda', 'id_estado' => 11],

            // Guárico (id_estado: 12)
            ['municipio' => 'Juan Germán Roscio', 'id_estado' => 12],

            // Nueva Esparta (id_estado: 17)
            ['municipio' => 'Mariño', 'id_estado' => 17],

            // Trujillo (id_estado: 21)
            ['municipio' => 'Valera', 'id_estado' => 21],

            // Vargas (id_estado: 22)
            ['municipio' => 'Vargas', 'id_estado' => 22],
        ];

        foreach ($municipios as $municipio) {
            DB::table('municipios')->insert(array_merge($municipio, [
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
