<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdministradoresTableSeeder extends Seeder
{
    public function run(): void
    {
        $administradores = [
            // Root (user_id: 1)
            [
                'user_id' => 1,
                'primer_nombre' => 'Super',
                'segundo_nombre' => null,
                'primer_apellido' => 'Administrador',
                'segundo_apellido' => 'Root',
                'tipo_documento' => 'V',
                'numero_documento' => '10000000',
                'fecha_nac' => '1980-01-01',
                'estado_id' => 10, // Distrito Capital
                'ciudad_id' => 1, // Caracas
                'municipio_id' => 1, // Libertador
                'parroquia_id' => 1, // Altagracia
                'direccion_detallada' => 'Av. Urdaneta, Torre Ejecutiva, Piso 10',
                'prefijo_tlf' => '+58',
                'numero_tlf' => '2129521234',
                'genero' => 'Masculino',
                'tipo_admin' => 'Root',
                'status' => true,
            ],

            // Admin 1 (user_id: 2)
            [
                'user_id' => 2,
                'primer_nombre' => 'Carlos',
                'segundo_nombre' => 'José',
                'primer_apellido' => 'Rodríguez',
                'segundo_apellido' => 'Pérez',
                'tipo_documento' => 'V',
                'numero_documento' => '15234567',
                'fecha_nac' => '1985-03-15',
                'estado_id' => 10, // Distrito Capital
                'ciudad_id' => 1, // Caracas
                'municipio_id' => 1, // Libertador
                'parroquia_id' => 7, // El Recreo
                'direccion_detallada' => 'Av. Francisco de Miranda, Centro Lido, Torre A, Piso 5',
                'prefijo_tlf' => '+58',
                'numero_tlf' => '4241234567',
                'genero' => 'Masculino',
                'tipo_admin' => 'Administrador',
                'status' => true,
            ],

            // Admin 2 (user_id: 3)
            [
                'user_id' => 3,
                'primer_nombre' => 'María',
                'segundo_nombre' => 'Gabriela',
                'primer_apellido' => 'González',
                'segundo_apellido' => 'Ramírez',
                'tipo_documento' => 'V',
                'numero_documento' => '18765432',
                'fecha_nac' => '1990-07-22',
                'estado_id' => 15, // Miranda
                'ciudad_id' => 2, // Los Teques
                'municipio_id' => 2, // Guaicaipuro
                'parroquia_id' => null,
                'direccion_detallada' => 'Calle Bolívar, Edificio San Martín, Apto 3-B',
                'prefijo_tlf' => '+58',
                'numero_tlf' => '4142345678',
                'genero' => 'Femenino',
                'tipo_admin' => 'Supervisor',
                'status' => true,
            ],

            // Admin 3 (user_id: 4)
            [
                'user_id' => 4,
                'primer_nombre' => 'Luis',
                'segundo_nombre' => 'Alberto',
                'primer_apellido' => 'Fernández',
                'segundo_apellido' => 'Morales',
                'tipo_documento' => 'V',
                'numero_documento' => '20123456',
                'fecha_nac' => '1988-11-10',
                'estado_id' => 7, // Carabobo
                'ciudad_id' => 9, // Valencia
                'municipio_id' => 8, // Valencia
                'parroquia_id' => 46, // Candelaria
                'direccion_detallada' => 'Av. Bolívar Norte, Centro Comercial Metrópolis, Nivel 2',
                'prefijo_tlf' => '+58',
                'numero_tlf' => '4243456789',
                'genero' => 'Masculino',
                'tipo_admin' => 'Administrador',
                'status' => true,
            ],
        // 1. Administrador Principal (Root) - User ID 1
        $admins[] = [
            'user_id' => 1,
            'primer_nombre' => 'Super',
            'primer_apellido' => 'Admin',
            'tipo_documento' => 'V',
            'numero_documento' => '10000001',
            'fecha_nac' => '1985-01-01',
            'estado_id' => 1,
            'ciudad_id' => 1,
            'municipio_id' => 1,
            'parroquia_id' => 1,
            'direccion_detallada' => 'Sede Central',
            'prefijo_tlf' => '+58',
            'numero_tlf' => '4120000001',
            'genero' => 'Masculino',
            'tipo_admin' => 'Root',
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        // 2. Administradores Adicionales - User IDs 2, 3, 4
        // Admin 1 (ID 2)
        $admins[] = [
            'user_id' => 2,
            'primer_nombre' => 'Ana',
            'primer_apellido' => 'Ramos',
            'tipo_documento' => 'V',
            'numero_documento' => '15000002',
            'fecha_nac' => '1990-05-15',
            'estado_id' => 1,
            'ciudad_id' => 1,
            'municipio_id' => 1,
            'parroquia_id' => 1,
            'direccion_detallada' => $faker->address,
            'prefijo_tlf' => '+58',
            'numero_tlf' => '4140000002',
            'genero' => 'Femenino',
            'tipo_admin' => 'Supervisor',
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        // Admin 2 (ID 3)
        $admins[] = [
            'user_id' => 3,
            'primer_nombre' => 'Pedro',
            'primer_apellido' => 'Castillo',
            'tipo_documento' => 'V',
            'numero_documento' => '16000003',
            'fecha_nac' => '1988-11-20',
            'estado_id' => 1,
            'ciudad_id' => 1,
            'municipio_id' => 1,
            'parroquia_id' => 1,
            'direccion_detallada' => $faker->address,
            'prefijo_tlf' => '+58',
            'numero_tlf' => '4160000003',
            'genero' => 'Masculino',
            'tipo_admin' => 'Recepcionista',
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        // Admin 3 (ID 4)
        $admins[] = [
            'user_id' => 4,
            'primer_nombre' => 'Luisa',
            'primer_apellido' => 'Mendoza',
            'tipo_documento' => 'V',
            'numero_documento' => '17000004',
            'fecha_nac' => '1992-03-10',
            'estado_id' => 1,
            'ciudad_id' => 1,
            'municipio_id' => 1,
            'parroquia_id' => 1,
            'direccion_detallada' => $faker->address,
            'prefijo_tlf' => '+58',
            'numero_tlf' => '4240000004',
            'genero' => 'Femenino',
            'tipo_admin' => 'Recepcionista',
            'status' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ];

            // Admin 4 (user_id: 5)
            [
                'user_id' => 5,
                'primer_nombre' => 'Ana',
                'segundo_nombre' => 'Carolina',
                'primer_apellido' => 'Martínez',
                'segundo_apellido' => 'Silva',
                'tipo_documento' => 'V',
                'numero_documento' => '22456789',
                'fecha_nac' => '1992-05-18',
                'estado_id' => 24, // Zulia
                'ciudad_id' => 6, // Maracaibo
                'municipio_id' => 5, // Maracaibo
                'parroquia_id' => 28, // Bolívar
                'direccion_detallada' => 'Av. 5 de Julio con Calle 72, Edificio Centro, Piso 3',
                'prefijo_tlf' => '+58',
                'numero_tlf' => '4264567890',
                'genero' => 'Femenino',
                'tipo_admin' => 'Recepcionista',
                'status' => true,
            ],

            // Admin 5 (user_id: 6)
            [
                'user_id' => 6,
                'primer_nombre' => 'Roberto',
                'segundo_nombre' => 'Antonio',
                'primer_apellido' => 'Sánchez',
                'segundo_apellido' => 'Díaz',
                'tipo_documento' => 'V',
                'numero_documento' => '17890123',
                'fecha_nac' => '1987-09-25',
                'estado_id' => 13, // Lara
                'ciudad_id' => 12, // Barquisimeto
                'municipio_id' => 11, // Iribarren
                'parroquia_id' => 57, // Catedral
                'direccion_detallada' => 'Carrera 19 con Calle 25, Torre Empresarial, Piso 8',
                'prefijo_tlf' => '+58',
                'numero_tlf' => '4145678901',
                'genero' => 'Masculino',
                'tipo_admin' => 'Supervisor',
                'status' => true,
            ],
        ];

        foreach ($administradores as $admin) {
            DB::table('administradores')->insert(array_merge($admin, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
