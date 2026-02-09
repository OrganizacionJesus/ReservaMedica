<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $roles = [
            [
                'nombre' => 'Root',
                'descripcion' => 'Administrador principal del sistema con acceso total y privilegios de configuración global',
            ],
            [
                'nombre' => 'Administrador',
                'descripcion' => 'Administrador de la clínica con permisos para gestionar usuarios, consultorios y configuraciones',
            ],
            [
                'nombre' => 'Médico',
                'descripcion' => 'Profesional médico con acceso a consultas, historias clínicas y gestión de citas',
            ],
            [
                'nombre' => 'Paciente',
                'descripcion' => 'Usuario paciente con acceso a solicitar citas, ver su historial médico y gestionar su perfil',
            ],
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