<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosTableSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            // Root (rol_id: 1)
            [
                'rol_id' => 1,
                'correo' => 'root@reservamedica.com',
                'password' => Hash::make('Root@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],

            // Administradores (rol_id: 2)
            [
                'rol_id' => 2,
                'correo' => 'admin1@reservamedica.com',
                'password' => Hash::make('Admin@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 2,
                'correo' => 'admin2@reservamedica.com',
                'password' => Hash::make('Admin@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 2,
                'correo' => 'admin3@reservamedica.com',
                'password' => Hash::make('Admin@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 2,
                'correo' => 'admin4@reservamedica.com',
                'password' => Hash::make('Admin@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 2,
                'correo' => 'admin5@reservamedica.com',
                'password' => Hash::make('Admin@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],

            // Médicos (rol_id: 3)
            [
                'rol_id' => 3,
                'correo' => 'medico1@reservamedica.com',
                'password' => Hash::make('Medico@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 3,
                'correo' => 'medico2@reservamedica.com',
                'password' => Hash::make('Medico@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 3,
                'correo' => 'medico3@reservamedica.com',
                'password' => Hash::make('Medico@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 3,
                'correo' => 'medico4@reservamedica.com',
                'password' => Hash::make('Medico@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 3,
                'correo' => 'medico5@reservamedica.com',
                'password' => Hash::make('Medico@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 3,
                'correo' => 'medico6@reservamedica.com',
                'password' => Hash::make('Medico@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 3,
                'correo' => 'medico7@reservamedica.com',
                'password' => Hash::make('Medico@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 3,
                'correo' => 'medico8@reservamedica.com',
                'password' => Hash::make('Medico@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 3,
                'correo' => 'medico9@reservamedica.com',
                'password' => Hash::make('Medico@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 3,
                'correo' => 'medico10@reservamedica.com',
                'password' => Hash::make('Medico@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 3,
                'correo' => 'medico11@reservamedica.com',
                'password' => Hash::make('Medico@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 3,
                'correo' => 'medico12@reservamedica.com',
                'password' => Hash::make('Medico@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],

            // Pacientes (rol_id: 4)
            [
                'rol_id' => 4,
                'correo' => 'paciente1@reservamedica.com',
                'password' => Hash::make('Paciente@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 4,
                'correo' => 'paciente2@reservamedica.com',
                'password' => Hash::make('Paciente@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 4,
                'correo' => 'paciente3@reservamedica.com',
                'password' => Hash::make('Paciente@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 4,
                'correo' => 'paciente4@reservamedica.com',
                'password' => Hash::make('Paciente@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 4,
                'correo' => 'paciente5@reservamedica.com',
                'password' => Hash::make('Paciente@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 4,
                'correo' => 'paciente6@reservamedica.com',
                'password' => Hash::make('Paciente@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 4,
                'correo' => 'paciente7@reservamedica.com',
                'password' => Hash::make('Paciente@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 4,
                'correo' => 'paciente8@reservamedica.com',
                'password' => Hash::make('Paciente@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 4,
                'correo' => 'paciente9@reservamedica.com',
                'password' => Hash::make('Paciente@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 4,
                'correo' => 'paciente10@reservamedica.com',
                'password' => Hash::make('Paciente@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 4,
                'correo' => 'paciente11@reservamedica.com',
                'password' => Hash::make('Paciente@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 4,
                'correo' => 'paciente12@reservamedica.com',
                'password' => Hash::make('Paciente@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 4,
                'correo' => 'paciente13@reservamedica.com',
                'password' => Hash::make('Paciente@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 4,
                'correo' => 'paciente14@reservamedica.com',
                'password' => Hash::make('Paciente@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 4,
                'correo' => 'paciente15@reservamedica.com',
                'password' => Hash::make('Paciente@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 4,
                'correo' => 'paciente16@reservamedica.com',
                'password' => Hash::make('Paciente@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 4,
                'correo' => 'paciente17@reservamedica.com',
                'password' => Hash::make('Paciente@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 4,
                'correo' => 'paciente18@reservamedica.com',
                'password' => Hash::make('Paciente@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 4,
                'correo' => 'paciente19@reservamedica.com',
                'password' => Hash::make('Paciente@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
            [
                'rol_id' => 4,
                'correo' => 'paciente20@reservamedica.com',
                'password' => Hash::make('Paciente@2026'),
                'status' => true,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($usuarios as $usuario) {
            DB::table('usuarios')->insert(array_merge($usuario, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
