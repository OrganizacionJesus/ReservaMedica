<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $roles = [
            ['id' => 1, 'nombre' => 'Administrador', 'descripcion' => 'Acceso completo al sistema'],
            ['id' => 2, 'nombre' => 'Médico', 'descripcion' => 'Acceso médico para citas y pacientes'],
            ['id' => 3, 'nombre' => 'Paciente', 'descripcion' => 'Acceso paciente para solicitar citas'],
        ];

        foreach ($roles as $rol) {
            DB::table('roles')->insert(array_merge($rol, [
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}