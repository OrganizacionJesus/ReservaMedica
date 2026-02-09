<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CiudadesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('ciudades')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

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
            ['id_ciudad' => 1, 'ciudad' => 'Caracas', 'id_estado' => 1],
            
            // Amazonas
            ['id_ciudad' => 2, 'ciudad' => 'Puerto Ayacucho', 'id_estado' => 2],
            
            // Anzoátegui
            ['id_ciudad' => 3, 'ciudad' => 'Barcelona', 'id_estado' => 3],
            ['id_ciudad' => 4, 'ciudad' => 'Puerto La Cruz', 'id_estado' => 3],
            ['id_ciudad' => 5, 'ciudad' => 'El Tigre', 'id_estado' => 3],
            
            // Apure
            ['id_ciudad' => 6, 'ciudad' => 'San Fernando de Apure', 'id_estado' => 4],
            
            // Aragua
            ['id_ciudad' => 7, 'ciudad' => 'Maracay', 'id_estado' => 5],
            ['id_ciudad' => 8, 'ciudad' => 'Turmero', 'id_estado' => 5],
            ['id_ciudad' => 9, 'ciudad' => 'La Victoria', 'id_estado' => 5],
            
            // Barinas
            ['id_ciudad' => 10, 'ciudad' => 'Barinas', 'id_estado' => 6],
            
            // Bolívar
            ['id_ciudad' => 11, 'ciudad' => 'Ciudad Bolívar', 'id_estado' => 7],
            ['id_ciudad' => 12, 'ciudad' => 'Puerto Ordaz', 'id_estado' => 7],
            ['id_ciudad' => 13, 'ciudad' => 'San Félix', 'id_estado' => 7],
            
            // Carabobo
            ['id_ciudad' => 14, 'ciudad' => 'Valencia', 'id_estado' => 8],
            ['id_ciudad' => 15, 'ciudad' => 'Puerto Cabello', 'id_estado' => 8],
            ['id_ciudad' => 16, 'ciudad' => 'Guacara', 'id_estado' => 8],
            
            // Cojedes
            ['id_ciudad' => 17, 'ciudad' => 'San Carlos', 'id_estado' => 9],
            
            // Delta Amacuro
            ['id_ciudad' => 18, 'ciudad' => 'Tucupita', 'id_estado' => 10],
            
            // Falcón
            ['id_ciudad' => 19, 'ciudad' => 'Coro', 'id_estado' => 11],
            ['id_ciudad' => 20, 'ciudad' => 'Punto Fijo', 'id_estado' => 11],
            
            // Guárico
            ['id_ciudad' => 21, 'ciudad' => 'San Juan de los Morros', 'id_estado' => 12],
            ['id_ciudad' => 22, 'ciudad' => 'Calabozo', 'id_estado' => 12],
            
            // Lara
            ['id_ciudad' => 23, 'ciudad' => 'Barquisimeto', 'id_estado' => 13],
            ['id_ciudad' => 24, 'ciudad' => 'Carora', 'id_estado' => 13],
            
            // Mérida
            ['id_ciudad' => 25, 'ciudad' => 'Mérida', 'id_estado' => 14],
            ['id_ciudad' => 26, 'ciudad' => 'El Vigía', 'id_estado' => 14],
            
            // Miranda
            ['id_ciudad' => 27, 'ciudad' => 'Los Teques', 'id_estado' => 15],
            ['id_ciudad' => 28, 'ciudad' => 'Guarenas', 'id_estado' => 15],
            ['id_ciudad' => 29, 'ciudad' => 'Guatire', 'id_estado' => 15],
            
            // Monagas
            ['id_ciudad' => 30, 'ciudad' => 'Maturín', 'id_estado' => 16],
            
            // Nueva Esparta
            ['id_ciudad' => 31, 'ciudad' => 'Porlamar', 'id_estado' => 17],
            ['id_ciudad' => 32, 'ciudad' => 'La Asunción', 'id_estado' => 17],
            
            // Portuguesa
            ['id_ciudad' => 33, 'ciudad' => 'Guanare', 'id_estado' => 18],
            ['id_ciudad' => 34, 'ciudad' => 'Acarigua', 'id_estado' => 18],
            
            // Sucre
            ['id_ciudad' => 35, 'ciudad' => 'Cumaná', 'id_estado' => 19],
            ['id_ciudad' => 36, 'ciudad' => 'Carúpano', 'id_estado' => 19],
            
            // Táchira
            ['id_ciudad' => 37, 'ciudad' => 'San Cristóbal', 'id_estado' => 20],
            ['id_ciudad' => 38, 'ciudad' => 'San Antonio del Táchira', 'id_estado' => 20],
            
            // Trujillo
            ['id_ciudad' => 39, 'ciudad' => 'Trujillo', 'id_estado' => 21],
            ['id_ciudad' => 40, 'ciudad' => 'Valera', 'id_estado' => 21],
            
            // Vargas
            ['id_ciudad' => 41, 'ciudad' => 'La Guaira', 'id_estado' => 22],
            ['id_ciudad' => 42, 'ciudad' => 'Catia La Mar', 'id_estado' => 22],
            
            // Yaracuy
            ['id_ciudad' => 43, 'ciudad' => 'San Felipe', 'id_estado' => 23],
            
            // Zulia
            ['id_ciudad' => 44, 'ciudad' => 'Maracaibo', 'id_estado' => 24],
            ['id_ciudad' => 45, 'ciudad' => 'Cabimas', 'id_estado' => 24],
            ['id_ciudad' => 46, 'ciudad' => 'Ciudad Ojeda', 'id_estado' => 24],
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
