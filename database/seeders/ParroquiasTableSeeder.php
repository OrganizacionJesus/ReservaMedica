<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParroquiasTableSeeder extends Seeder
{
    public function run(): void
    {
        $parroquias = [
            // Municipio Libertador - Caracas (id_municipio: 1)
            ['parroquia' => 'Altagracia', 'id_municipio' => 1],
            ['parroquia' => 'Candelaria', 'id_municipio' => 1],
            ['parroquia' => 'Catedral', 'id_municipio' => 1],
            ['parroquia' => 'La Pastora', 'id_municipio' => 1],
            ['parroquia' => 'San Juan', 'id_municipio' => 1],
            ['parroquia' => 'Santa Rosalía', 'id_municipio' => 1],
            ['parroquia' => 'El Recreo', 'id_municipio' => 1],
            ['parroquia' => 'San Bernardino', 'id_municipio' => 1],
            ['parroquia' => 'El Paraíso', 'id_municipio' => 1],
            ['parroquia' => 'San Pedro', 'id_municipio' => 1],
            ['parroquia' => 'Caricuao', 'id_municipio' => 1],
            ['parroquia' => 'La Vega', 'id_municipio' => 1],
            ['parroquia' => 'Macarao', 'id_municipio' => 1],
            ['parroquia' => 'El Valle', 'id_municipio' => 1],
            ['parroquia' => 'Coche', 'id_municipio' => 1],
            ['parroquia' => 'Antímano', 'id_municipio' => 1],
            ['parroquia' => 'San Agustín', 'id_municipio' => 1],
            ['parroquia' => 'Santa Teresa', 'id_municipio' => 1],
            ['parroquia' => 'Sucre (Catia)', 'id_municipio' => 1],
            ['parroquia' => '23 de Enero', 'id_municipio' => 1],
            ['parroquia' => 'San José', 'id_municipio' => 1],
            ['parroquia' => 'La Candelaria', 'id_municipio' => 1],

            // Municipio Sucre - Petare (id_municipio: 4)
            ['parroquia' => 'Petare', 'id_municipio' => 4],
            ['parroquia' => 'Leoncio Martínez', 'id_municipio' => 4],
            ['parroquia' => 'Caucagüita', 'id_municipio' => 4],
            ['parroquia' => 'Filas de Mariche', 'id_municipio' => 4],
            ['parroquia' => 'La Dolorita', 'id_municipio' => 4],

            // Municipio Maracaibo (id_municipio: 5)
            ['parroquia' => 'Bolívar', 'id_municipio' => 5],
            ['parroquia' => 'Coquivacoa', 'id_municipio' => 5],
            ['parroquia' => 'Cristo de Aranza', 'id_municipio' => 5],
            ['parroquia' => 'Chiquinquirá', 'id_municipio' => 5],
            ['parroquia' => 'Santa Lucía', 'id_municipio' => 5],
            ['parroquia' => 'Olegario Villalobos', 'id_municipio' => 5],
            ['parroquia' => 'Juana de Ávila', 'id_municipio' => 5],
            ['parroquia' => 'Caracciolo Parra Pérez', 'id_municipio' => 5],
            ['parroquia' => 'Idelfonso Vásquez', 'id_municipio' => 5],
            ['parroquia' => 'Cacique Mara', 'id_municipio' => 5],
            ['parroquia' => 'Cecilio Acosta', 'id_municipio' => 5],
            ['parroquia' => 'Raúl Leoni', 'id_municipio' => 5],
            ['parroquia' => 'Francisco Eugenio Bustamante', 'id_municipio' => 5],
            ['parroquia' => 'Manuel Dagnino', 'id_municipio' => 5],
            ['parroquia' => 'Luis Hurtado Higuera', 'id_municipio' => 5],
            ['parroquia' => 'Venancio Pulgar', 'id_municipio' => 5],
            ['parroquia' => 'Antonio Borjas Romero', 'id_municipio' => 5],
            ['parroquia' => 'San Isidro', 'id_municipio' => 5],

            // Municipio Valencia (id_municipio: 8)
            ['parroquia' => 'Candelaria', 'id_municipio' => 8],
            ['parroquia' => 'Catedral', 'id_municipio' => 8],
            ['parroquia' => 'El Socorro', 'id_municipio' => 8],
            ['parroquia' => 'Miguel Peña', 'id_municipio' => 8],
            ['parroquia' => 'Rafael Urdaneta', 'id_municipio' => 8],
            ['parroquia' => 'San Blas', 'id_municipio' => 8],
            ['parroquia' => 'San José', 'id_municipio' => 8],
            ['parroquia' => 'Santa Rosa', 'id_municipio' => 8],
            ['parroquia' => 'Negro Primero', 'id_municipio' => 8],

            // Municipio Iribarren - Barquisimeto (id_municipio: 11)
            ['parroquia' => 'Aguedo Felipe Alvarado', 'id_municipio' => 11],
            ['parroquia' => 'Buena Vista', 'id_municipio' => 11],
            ['parroquia' => 'Catedral', 'id_municipio' => 11],
            ['parroquia' => 'Concepción', 'id_municipio' => 11],
            ['parroquia' => 'El Cují', 'id_municipio' => 11],
            ['parroquia' => 'Juan de Villegas', 'id_municipio' => 11],
            ['parroquia' => 'Santa Rosa', 'id_municipio' => 11],
            ['parroquia' => 'Tamaca', 'id_municipio' => 11],
            ['parroquia' => 'Unión', 'id_municipio' => 11],

            // Municipio Girardot - Maracay (id_municipio: 13)
            ['parroquia' => 'Andrés Eloy Blanco', 'id_municipio' => 13],
            ['parroquia' => 'Los Tacarigua', 'id_municipio' => 13],
            ['parroquia' => 'Las Delicias', 'id_municipio' => 13],
            ['parroquia' => 'Choroní', 'id_municipio' => 13],
            ['parroquia' => 'Madre María de San José', 'id_municipio' => 13],
            ['parroquia' => 'Joaquín Crespo', 'id_municipio' => 13],
            ['parroquia' => 'Pedro José Ovalles', 'id_municipio' => 13],
            ['parroquia' => 'José Casanova Godoy', 'id_municipio' => 13],
            ['parroquia' => 'Andrés Eloy Blanco (Sur)', 'id_municipio' => 13],

            // Municipio San Cristóbal (id_municipio: 17)
            ['parroquia' => 'San Juan Bautista', 'id_municipio' => 17],
            ['parroquia' => 'Pedro María Morantes', 'id_municipio' => 17],
            ['parroquia' => 'Dr. Francisco Romero Lobo', 'id_municipio' => 17],
            ['parroquia' => 'La Concordia', 'id_municipio' => 17],
            ['parroquia' => 'San Sebastián', 'id_municipio' => 17],
        ];

        foreach ($parroquias as $parroquia) {
            DB::table('parroquias')->insert(array_merge($parroquia, [
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
