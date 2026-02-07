<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParroquiasTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('parroquias')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $parroquias = [
            // Municipio Libertador (Distrito Capital)
            ['id_parroquia' => 1, 'parroquia' => 'Catedral', 'id_municipio' => 1],
            ['id_parroquia' => 2, 'parroquia' => 'La Candelaria', 'id_municipio' => 1],
            ['id_parroquia' => 3, 'parroquia' => 'San José', 'id_municipio' => 1],
            ['id_parroquia' => 4, 'parroquia' => 'El Recreo', 'id_municipio' => 1],
            ['id_parroquia' => 5, 'parroquia' => 'La Pastora', 'id_municipio' => 1],
            ['id_parroquia' => 6, 'parroquia' => '23 de Enero', 'id_municipio' => 1],
            
            // Municipio Atures (Amazonas)
            ['id_parroquia' => 7, 'parroquia' => 'Fernando Girón Tovar', 'id_municipio' => 2],
            ['id_parroquia' => 8, 'parroquia' => 'Luis Alberto Gómez', 'id_municipio' => 2],
            
            // Municipio Bolívar (Anzoátegui)
            ['id_parroquia' => 9, 'parroquia' => 'Barcelona', 'id_municipio' => 4],
            ['id_parroquia' => 10, 'parroquia' => 'El Carmen', 'id_municipio' => 4],
            
            // Municipio Guanta (Anzoátegui)
            ['id_parroquia' => 11, 'parroquia' => 'Guanta', 'id_municipio' => 5],
            ['id_parroquia' => 12, 'parroquia' => 'Chorreron', 'id_municipio' => 5],
            
            // Municipio San Fernando (Apure)
            ['id_parroquia' => 13, 'parroquia' => 'San Fernando', 'id_municipio' => 7],
            ['id_parroquia' => 14, 'parroquia' => 'El Recreo', 'id_municipio' => 7],
            
            // Municipio Girardot (Aragua)
            ['id_parroquia' => 15, 'parroquia' => 'Las Delicias', 'id_municipio' => 9],
            ['id_parroquia' => 16, 'parroquia' => 'Madre María', 'id_municipio' => 9],
            ['id_parroquia' => 17, 'parroquia' => 'San José', 'id_municipio' => 9],
            
            // Municipio Santiago Mariño (Aragua)
            ['id_parroquia' => 18, 'parroquia' => 'Turmero', 'id_municipio' => 10],
            ['id_parroquia' => 19, 'parroquia' => 'Saman de Güere', 'id_municipio' => 10],
            
            // Municipio Barinas (Barinas)
            ['id_parroquia' => 20, 'parroquia' => 'Barinas', 'id_municipio' => 12],
            ['id_parroquia' => 21, 'parroquia' => 'El Carmen', 'id_municipio' => 12],
            
            // Municipio Heres (Bolívar)
            ['id_parroquia' => 22, 'parroquia' => 'Catedral', 'id_municipio' => 14],
            ['id_parroquia' => 23, 'parroquia' => 'Vista Hermosa', 'id_municipio' => 14],
            
            // Municipio Caroní (Bolívar)
            ['id_parroquia' => 24, 'parroquia' => 'Unare', 'id_municipio' => 15],
            ['id_parroquia' => 25, 'parroquia' => 'Cachamay', 'id_municipio' => 15],
            ['id_parroquia' => 26, 'parroquia' => 'Universidad', 'id_municipio' => 15],
            
            // Municipio Valencia (Carabobo)
            ['id_parroquia' => 27, 'parroquia' => 'Catedral', 'id_municipio' => 17],
            ['id_parroquia' => 28, 'parroquia' => 'San Blas', 'id_municipio' => 17],
            ['id_parroquia' => 29, 'parroquia' => 'Rafael Urdaneta', 'id_municipio' => 17],
            ['id_parroquia' => 30, 'parroquia' => 'Candelaria', 'id_municipio' => 17],
            
            // Municipio Puerto Cabello (Carabobo)
            ['id_parroquia' => 31, 'parroquia' => 'Puerto Cabello', 'id_municipio' => 18],
            ['id_parroquia' => 32, 'parroquia' => 'Borburata', 'id_municipio' => 18],
            
            // Municipio Ezequiel Zamora (Cojedes)
            ['id_parroquia' => 33, 'parroquia' => 'San Carlos de Austria', 'id_municipio' => 21],
            
            // Municipio Tucupita (Delta Amacuro)
            ['id_parroquia' => 34, 'parroquia' => 'San Rafael', 'id_municipio' => 23],
            ['id_parroquia' => 35, 'parroquia' => 'Virgen del Valle', 'id_municipio' => 23],
            
            // Municipio Miranda (Falcón)
            ['id_parroquia' => 36, 'parroquia' => 'Coro', 'id_municipio' => 25],
            ['id_parroquia' => 37, 'parroquia' => 'San Antonio', 'id_municipio' => 25],
            
            // Municipio Carirubana (Falcón)
            ['id_parroquia' => 38, 'parroquia' => 'Norte', 'id_municipio' => 26],
            ['id_parroquia' => 39, 'parroquia' => 'Carirubana', 'id_municipio' => 26],
            
            // Municipio Juan Germán Roscio (Guárico)
            ['id_parroquia' => 40, 'parroquia' => 'San Juan de los Morros', 'id_municipio' => 28],
            
            // Municipio Francisco de Miranda (Guárico)
            ['id_parroquia' => 41, 'parroquia' => 'Calabozo', 'id_municipio' => 29],
            
            // Municipio Iribarren (Lara)
            ['id_parroquia' => 42, 'parroquia' => 'Catedral', 'id_municipio' => 30],
            ['id_parroquia' => 43, 'parroquia' => 'Concepción', 'id_municipio' => 30],
            ['id_parroquia' => 44, 'parroquia' => 'Santa Rosa', 'id_municipio' => 30],
            ['id_parroquia' => 45, 'parroquia' => 'Juan de Villegas', 'id_municipio' => 30],
            
            // Municipio Torres (Lara)
            ['id_parroquia' => 46, 'parroquia' => 'Carora', 'id_municipio' => 31],
            
            // Municipio Libertador (Mérida)
            ['id_parroquia' => 47, 'parroquia' => 'El Llano', 'id_municipio' => 33],
            ['id_parroquia' => 48, 'parroquia' => 'Domingo Peña', 'id_municipio' => 33],
            ['id_parroquia' => 49, 'parroquia' => 'Milla', 'id_municipio' => 33],
            
            // Municipio Alberto Adriani (Mérida)
            ['id_parroquia' => 50, 'parroquia' => 'El Vigía', 'id_municipio' => 34],
            
            // Municipio Guaicaipuro (Miranda)
            ['id_parroquia' => 51, 'parroquia' => 'Los Teques', 'id_municipio' => 36],
            ['id_parroquia' => 52, 'parroquia' => 'Cecilio Acosta', 'id_municipio' => 36],
            
            // Municipio Plaza (Miranda)
            ['id_parroquia' => 53, 'parroquia' => 'Guarenas', 'id_municipio' => 37],
            
            // Municipio Zamora (Miranda)
            ['id_parroquia' => 54, 'parroquia' => 'Guatire', 'id_municipio' => 38],
            
            // Municipio Sucre (Miranda)
            ['id_parroquia' => 55, 'parroquia' => 'Petare', 'id_municipio' => 39],
            ['id_parroquia' => 56, 'parroquia' => 'Leoncio Martínez', 'id_municipio' => 39],
            
            // Municipio Maturín (Monagas)
            ['id_parroquia' => 57, 'parroquia' => 'San Simón', 'id_municipio' => 40],
            ['id_parroquia' => 58, 'parroquia' => 'Alto de Los Godos', 'id_municipio' => 40],
            
            // Municipio Mariño (Nueva Esparta)
            ['id_parroquia' => 59, 'parroquia' => 'Porlamar', 'id_municipio' => 42],
            
            // Municipio Arismendi (Nueva Esparta)
            ['id_parroquia' => 60, 'parroquia' => 'La Asunción', 'id_municipio' => 43],
            
            // Municipio Guanare (Portuguesa)
            ['id_parroquia' => 61, 'parroquia' => 'Guanare', 'id_municipio' => 44],
            
            // Municipio Páez (Portuguesa)
            ['id_parroquia' => 62, 'parroquia' => 'Acarigua', 'id_municipio' => 45],
            
            // Municipio Sucre (Sucre)
            ['id_parroquia' => 63, 'parroquia' => 'Altagracia', 'id_municipio' => 47],
            ['id_parroquia' => 64, 'parroquia' => 'Santa Inés', 'id_municipio' => 47],
            
            // Municipio Bermúdez (Sucre)
            ['id_parroquia' => 65, 'parroquia' => 'Carúpano', 'id_municipio' => 48],
            
            // Municipio San Cristóbal (Táchira)
            ['id_parroquia' => 66, 'parroquia' => 'San Juan Bautista', 'id_municipio' => 50],
            ['id_parroquia' => 67, 'parroquia' => 'Pedro María Morantes', 'id_municipio' => 50],
            
            // Municipio Cárdenas (Táchira)
            ['id_parroquia' => 68, 'parroquia' => 'Táriba', 'id_municipio' => 51],
            
            // Municipio Trujillo (Trujillo)
            ['id_parroquia' => 69, 'parroquia' => 'Trujillo', 'id_municipio' => 53],
            
            // Municipio Valera (Trujillo)
            ['id_parroquia' => 70, 'parroquia' => 'Mercedes Díaz', 'id_municipio' => 54],
            
            // Municipio Vargas (Vargas)
            ['id_parroquia' => 71, 'parroquia' => 'Maiquetía', 'id_municipio' => 56],
            ['id_parroquia' => 72, 'parroquia' => 'Catia La Mar', 'id_municipio' => 56],
            ['id_parroquia' => 73, 'parroquia' => 'La Guaira', 'id_municipio' => 56],
            
            // Municipio San Felipe (Yaracuy)
            ['id_parroquia' => 74, 'parroquia' => 'San Felipe', 'id_municipio' => 57],
            
            // Municipio Maracaibo (Zulia)
            ['id_parroquia' => 75, 'parroquia' => 'Bolívar', 'id_municipio' => 59],
            ['id_parroquia' => 76, 'parroquia' => 'Coquivacoa', 'id_municipio' => 59],
            ['id_parroquia' => 77, 'parroquia' => 'Cristo de Aranza', 'id_municipio' => 59],
            ['id_parroquia' => 78, 'parroquia' => 'Santa Lucía', 'id_municipio' => 59],
            
            // Municipio Cabimas (Zulia)
            ['id_parroquia' => 79, 'parroquia' => 'Ambrosio', 'id_municipio' => 60],
            ['id_parroquia' => 80, 'parroquia' => 'Carmen Herrera', 'id_municipio' => 60],
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
