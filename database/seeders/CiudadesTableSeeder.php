<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CiudadesTableSeeder extends Seeder
{
    public function run(): void
    {
        $ciudades = [
            // Distrito Capital
            ['ciudad' => 'Caracas', 'id_estado' => 10],

            // Miranda
            ['ciudad' => 'Los Teques', 'id_estado' => 15],
            ['ciudad' => 'Guarenas', 'id_estado' => 15],
            ['ciudad' => 'Guatire', 'id_estado' => 15],
            ['ciudad' => 'Petare', 'id_estado' => 15],

            // Zulia
            ['ciudad' => 'Maracaibo', 'id_estado' => 24],
            ['ciudad' => 'Cabimas', 'id_estado' => 24],
            ['ciudad' => 'Ciudad Ojeda', 'id_estado' => 24],

            // Carabobo
            ['ciudad' => 'Valencia', 'id_estado' => 7],
            ['ciudad' => 'Puerto Cabello', 'id_estado' => 7],
            ['ciudad' => 'Guacara', 'id_estado' => 7],

            // Lara
            ['ciudad' => 'Barquisimeto', 'id_estado' => 13],
            ['ciudad' => 'Cabudare', 'id_estado' => 13],
            ['ciudad' => 'Carora', 'id_estado' => 13],

            // Aragua
            ['ciudad' => 'Maracay', 'id_estado' => 4],
            ['ciudad' => 'Turmero', 'id_estado' => 4],
            ['ciudad' => 'La Victoria', 'id_estado' => 4],

            // Anzoátegui
            ['ciudad' => 'Barcelona', 'id_estado' => 2],
            ['ciudad' => 'Puerto La Cruz', 'id_estado' => 2],
            ['ciudad' => 'El Tigre', 'id_estado' => 2],

            // Táchira
            ['ciudad' => 'San Cristóbal', 'id_estado' => 20],
            ['ciudad' => 'Táriba', 'id_estado' => 20],
            ['ciudad' => 'San Antonio del Táchira', 'id_estado' => 20],

            // Mérida
            ['ciudad' => 'Mérida', 'id_estado' => 14],
            ['ciudad' => 'El Vigía', 'id_estado' => 14],
            ['ciudad' => 'Ejido', 'id_estado' => 14],

            // Bolívar
            ['ciudad' => 'Ciudad Bolívar', 'id_estado' => 6],
            ['ciudad' => 'Puerto Ordaz', 'id_estado' => 6],
            ['ciudad' => 'San Félix', 'id_estado' => 6],

            // Monagas
            ['ciudad' => 'Maturín', 'id_estado' => 16],
            ['ciudad' => 'Punta de Mata', 'id_estado' => 16],

            // Sucre
            ['ciudad' => 'Cumaná', 'id_estado' => 19],
            ['ciudad' => 'Carúpano', 'id_estado' => 19],

            // Portuguesa
            ['ciudad' => 'Guanare', 'id_estado' => 18],
            ['ciudad' => 'Acarigua', 'id_estado' => 18],

            // Barinas
            ['ciudad' => 'Barinas', 'id_estado' => 5],

            // Falcón
            ['ciudad' => 'Coro', 'id_estado' => 11],
            ['ciudad' => 'Punto Fijo', 'id_estado' => 11],

            // Guárico
            ['ciudad' => 'San Juan de los Morros', 'id_estado' => 12],
            ['ciudad' => 'Calabozo', 'id_estado' => 12],

            // Nueva Esparta
            ['ciudad' => 'La Asunción', 'id_estado' => 17],
            ['ciudad' => 'Porlamar', 'id_estado' => 17],

            // Trujillo
            ['ciudad' => 'Trujillo', 'id_estado' => 21],
            ['ciudad' => 'Valera', 'id_estado' => 21],

            // Vargas
            ['ciudad' => 'La Guaira', 'id_estado' => 22],
            ['ciudad' => 'Maiquetía', 'id_estado' => 22],

            // Yaracuy
            ['ciudad' => 'San Felipe', 'id_estado' => 23],

            // Cojedes
            ['ciudad' => 'San Carlos', 'id_estado' => 8],

            // Apure
            ['ciudad' => 'San Fernando de Apure', 'id_estado' => 3],

            // Delta Amacuro
            ['ciudad' => 'Tucupita', 'id_estado' => 9],

            // Amazonas
            ['ciudad' => 'Puerto Ayacucho', 'id_estado' => 1],
        ];

        foreach ($ciudades as $ciudad) {
            DB::table('ciudades')->insert(array_merge($ciudad, [
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
