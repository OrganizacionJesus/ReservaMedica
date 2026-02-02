<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosTableSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            ['estado' => 'Amazonas', 'iso_3166_2' => 'VE-Z'],
            ['estado' => 'Anzoátegui', 'iso_3166_2' => 'VE-B'],
            ['estado' => 'Apure', 'iso_3166_2' => 'VE-C'],
            ['estado' => 'Aragua', 'iso_3166_2' => 'VE-D'],
            ['estado' => 'Barinas', 'iso_3166_2' => 'VE-E'],
            ['estado' => 'Bolívar', 'iso_3166_2' => 'VE-F'],
            ['estado' => 'Carabobo', 'iso_3166_2' => 'VE-G'],
            ['estado' => 'Cojedes', 'iso_3166_2' => 'VE-H'],
            ['estado' => 'Delta Amacuro', 'iso_3166_2' => 'VE-Y'],
            ['estado' => 'Distrito Capital', 'iso_3166_2' => 'VE-A'],
            ['estado' => 'Falcón', 'iso_3166_2' => 'VE-I'],
            ['estado' => 'Guárico', 'iso_3166_2' => 'VE-J'],
            ['estado' => 'Lara', 'iso_3166_2' => 'VE-K'],
            ['estado' => 'Mérida', 'iso_3166_2' => 'VE-L'],
            ['estado' => 'Miranda', 'iso_3166_2' => 'VE-M'],
            ['estado' => 'Monagas', 'iso_3166_2' => 'VE-N'],
            ['estado' => 'Nueva Esparta', 'iso_3166_2' => 'VE-O'],
            ['estado' => 'Portuguesa', 'iso_3166_2' => 'VE-P'],
            ['estado' => 'Sucre', 'iso_3166_2' => 'VE-R'],
            ['estado' => 'Táchira', 'iso_3166_2' => 'VE-S'],
            ['estado' => 'Trujillo', 'iso_3166_2' => 'VE-T'],
            ['estado' => 'Vargas', 'iso_3166_2' => 'VE-X'],
            ['estado' => 'Yaracuy', 'iso_3166_2' => 'VE-U'],
            ['estado' => 'Zulia', 'iso_3166_2' => 'VE-V'],
        ];

        foreach ($estados as $estado) {
            DB::table('estados')->insert(array_merge($estado, [
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
