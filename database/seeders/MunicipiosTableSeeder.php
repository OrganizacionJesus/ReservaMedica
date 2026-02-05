<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MunicipiosTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('municipios')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $municipios = [
            // Distrito Capital
            ['id_municipio' => 1, 'municipio' => 'Libertador', 'id_estado' => 1],
            
            // Amazonas
            ['id_municipio' => 2, 'municipio' => 'Atures', 'id_estado' => 2],
            ['id_municipio' => 3, 'municipio' => 'Alto Orinoco', 'id_estado' => 2],
            
            // Anzoátegui
            ['id_municipio' => 4, 'municipio' => 'Bolívar', 'id_estado' => 3],
            ['id_municipio' => 5, 'municipio' => 'Guanta', 'id_estado' => 3],
            ['id_municipio' => 6, 'municipio' => 'Simón Rodríguez', 'id_estado' => 3],
            
            // Apure
            ['id_municipio' => 7, 'municipio' => 'San Fernando', 'id_estado' => 4],
            ['id_municipio' => 8, 'municipio' => 'Achaguas', 'id_estado' => 4],
            
            // Aragua
            ['id_municipio' => 9, 'municipio' => 'Girardot', 'id_estado' => 5],
            ['id_municipio' => 10, 'municipio' => 'Santiago Mariño', 'id_estado' => 5],
            ['id_municipio' => 11, 'municipio' => 'José Félix Ribas', 'id_estado' => 5],
            
            // Barinas
            ['id_municipio' => 12, 'municipio' => 'Barinas', 'id_estado' => 6],
            ['id_municipio' => 13, 'municipio' => 'Pedraza', 'id_estado' => 6],
            
            // Bolívar
            ['id_municipio' => 14, 'municipio' => 'Heres', 'id_estado' => 7],
            ['id_municipio' => 15, 'municipio' => 'Caroní', 'id_estado' => 7],
            ['id_municipio' => 16, 'municipio' => 'Piar', 'id_estado' => 7],
            
            // Carabobo
            ['id_municipio' => 17, 'municipio' => 'Valencia', 'id_estado' => 8],
            ['id_municipio' => 18, 'municipio' => 'Puerto Cabello', 'id_estado' => 8],
            ['id_municipio' => 19, 'municipio' => 'Guacara', 'id_estado' => 8],
            ['id_municipio' => 20, 'municipio' => 'Naguanagua', 'id_estado' => 8],
            
            // Cojedes
            ['id_municipio' => 21, 'municipio' => 'Ezequiel Zamora', 'id_estado' => 9],
            ['id_municipio' => 22, 'municipio' => 'Tinaquillo', 'id_estado' => 9],
            
            // Delta Amacuro
            ['id_municipio' => 23, 'municipio' => 'Tucupita', 'id_estado' => 10],
            ['id_municipio' => 24, 'municipio' => 'Antonio Díaz', 'id_estado' => 10],
            
            // Falcón
            ['id_municipio' => 25, 'municipio' => 'Miranda', 'id_estado' => 11],
            ['id_municipio' => 26, 'municipio' => 'Carirubana', 'id_estado' => 11],
            ['id_municipio' => 27, 'municipio' => 'Falcón', 'id_estado' => 11],
            
            // Guárico
            ['id_municipio' => 28, 'municipio' => 'Juan Germán Roscio', 'id_estado' => 12],
            ['id_municipio' => 29, 'municipio' => 'Francisco de Miranda', 'id_estado' => 12],
            
            // Lara
            ['id_municipio' => 30, 'municipio' => 'Iribarren', 'id_estado' => 13],
            ['id_municipio' => 31, 'municipio' => 'Torres', 'id_estado' => 13],
            ['id_municipio' => 32, 'municipio' => 'Palavecino', 'id_estado' => 13],
            
            // Mérida
            ['id_municipio' => 33, 'municipio' => 'Libertador', 'id_estado' => 14],
            ['id_municipio' => 34, 'municipio' => 'Alberto Adriani', 'id_estado' => 14],
            ['id_municipio' => 35, 'municipio' => 'Santos Marquina', 'id_estado' => 14],
            
            // Miranda
            ['id_municipio' => 36, 'municipio' => 'Guaicaipuro', 'id_estado' => 15],
            ['id_municipio' => 37, 'municipio' => 'Plaza', 'id_estado' => 15],
            ['id_municipio' => 38, 'municipio' => 'Zamora', 'id_estado' => 15],
            ['id_municipio' => 39, 'municipio' => 'Sucre', 'id_estado' => 15],
            
            // Monagas
            ['id_municipio' => 40, 'municipio' => 'Maturín', 'id_estado' => 16],
            ['id_municipio' => 41, 'municipio' => 'Piar', 'id_estado' => 16],
            
            // Nueva Esparta
            ['id_municipio' => 42, 'municipio' => 'Mariño', 'id_estado' => 17],
            ['id_municipio' => 43, 'municipio' => 'Arismendi', 'id_estado' => 17],
            
            // Portuguesa
            ['id_municipio' => 44, 'municipio' => 'Guanare', 'id_estado' => 18],
            ['id_municipio' => 45, 'municipio' => 'Páez', 'id_estado' => 18],
            ['id_municipio' => 46, 'municipio' => 'Araure', 'id_estado' => 18],
            
            // Sucre
            ['id_municipio' => 47, 'municipio' => 'Sucre', 'id_estado' => 19],
            ['id_municipio' => 48, 'municipio' => 'Bermúdez', 'id_estado' => 19],
            ['id_municipio' => 49, 'municipio' => 'Ribero', 'id_estado' => 19],
            
            // Táchira
            ['id_municipio' => 50, 'municipio' => 'San Cristóbal', 'id_estado' => 20],
            ['id_municipio' => 51, 'municipio' => 'Cárdenas', 'id_estado' => 20],
            ['id_municipio' => 52, 'municipio' => 'Torbes', 'id_estado' => 20],
            
            // Trujillo
            ['id_municipio' => 53, 'municipio' => 'Trujillo', 'id_estado' => 21],
            ['id_municipio' => 54, 'municipio' => 'Valera', 'id_estado' => 21],
            ['id_municipio' => 55, 'municipio' => 'Boconó', 'id_estado' => 21],
            
            // Vargas
            ['id_municipio' => 56, 'municipio' => 'Vargas', 'id_estado' => 22],
            
            // Yaracuy
            ['id_municipio' => 57, 'municipio' => 'San Felipe', 'id_estado' => 23],
            ['id_municipio' => 58, 'municipio' => 'Nirgua', 'id_estado' => 23],
            
            // Zulia
            ['id_municipio' => 59, 'municipio' => 'Maracaibo', 'id_estado' => 24],
            ['id_municipio' => 60, 'municipio' => 'Cabimas', 'id_estado' => 24],
            ['id_municipio' => 61, 'municipio' => 'Lagunillas', 'id_estado' => 24],
            ['id_municipio' => 62, 'municipio' => 'Mara', 'id_estado' => 24],
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
