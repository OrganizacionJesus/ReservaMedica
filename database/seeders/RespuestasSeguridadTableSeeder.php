<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RespuestasSeguridadTableSeeder extends Seeder
{
    public function run(): void
    {
        $respuestas = [
            // Root (user_id: 1)
            [
                'user_id' => 1,
                'pregunta_id' => 1,
                'respuesta_hash' => Hash::make('Max'),
            ],
            [
                'user_id' => 1,
                'pregunta_id' => 2,
                'respuesta_hash' => Hash::make('Caracas'),
            ],

            // Admin 1 (user_id: 2)
            [
                'user_id' => 2,
                'pregunta_id' => 3,
                'respuesta_hash' => Hash::make('Arepas'),
            ],
            [
                'user_id' => 2,
                'pregunta_id' => 5,
                'respuesta_hash' => Hash::make('Rodríguez'),
            ],

            // Admin 2 (user_id: 3)
            [
                'user_id' => 3,
                'pregunta_id' => 1,
                'respuesta_hash' => Hash::make('Luna'),
            ],
            [
                'user_id' => 3,
                'pregunta_id' => 4,
                'respuesta_hash' => Hash::make('Andrea'),
            ],

            // Admin 3 (user_id: 4)
            [
                'user_id' => 4,
                'pregunta_id' => 2,
                'respuesta_hash' => Hash::make('Valencia'),
            ],
            [
                'user_id' => 4,
                'pregunta_id' => 6,
                'respuesta_hash' => Hash::make('Escuela Bolivariana'),
            ],

            // Admin 4 (user_id: 5)
            [
                'user_id' => 5,
                'pregunta_id' => 7,
                'respuesta_hash' => Hash::make('Azul'),
            ],
            [
                'user_id' => 5,
                'pregunta_id' => 8,
                'respuesta_hash' => Hash::make('Casablanca'),
            ],

            // Admin 5 (user_id: 6)
            [
                'user_id' => 6,
                'pregunta_id' => 9,
                'respuesta_hash' => Hash::make('Banco Provincial'),
            ],
            [
                'user_id' => 6,
                'pregunta_id' => 10,
                'respuesta_hash' => Hash::make('Caracas FC'),
            ],

            // Médico 1 (user_id: 7)
            [
                'user_id' => 7,
                'pregunta_id' => 1,
                'respuesta_hash' => Hash::make('Toby'),
            ],
            [
                'user_id' => 7,
                'pregunta_id' => 11,
                'respuesta_hash' => Hash::make('Rafael'),
            ],

            // Médico 2 (user_id: 8)
            [
                'user_id' => 8,
                'pregunta_id' => 2,
                'respuesta_hash' => Hash::make('Petare'),
            ],
            [
                'user_id' => 8,
                'pregunta_id' => 12,
                'respuesta_hash' => Hash::make('2000'),
            ],

            // Médico 3 (user_id: 9)
            [
                'user_id' => 9,
                'pregunta_id' => 3,
                'respuesta_hash' => Hash::make('Pabellón Criollo'),
            ],
            [
                'user_id' => 9,
                'pregunta_id' => 13,
                'respuesta_hash' => Hash::make('Cien Años de Soledad'),
            ],

            // Médico 4 (user_id: 10)
            [
                'user_id' => 10,
                'pregunta_id' => 4,
                'respuesta_hash' => Hash::make('Carlos'),
            ],
            [
                'user_id' => 10,
                'pregunta_id' => 14,
                'respuesta_hash' => Hash::make('Profesor García'),
            ],

            // Médico 5 (user_id: 11)
            [
                'user_id' => 11,
                'pregunta_id' => 5,
                'respuesta_hash' => Hash::make('Vargas'),
            ],
            [
                'user_id' => 11,
                'pregunta_id' => 15,
                'respuesta_hash' => Hash::make('Los Roques'),
            ],

            // Médico 6 (user_id: 12)
            [
                'user_id' => 12,
                'pregunta_id' => 6,
                'respuesta_hash' => Hash::make('Colegio San Agustín'),
            ],
            [
                'user_id' => 12,
                'pregunta_id' => 1,
                'respuesta_hash' => Hash::make('Rocky'),
            ],

            // Médico 7 (user_id: 13)
            [
                'user_id' => 13,
                'pregunta_id' => 7,
                'respuesta_hash' => Hash::make('Verde'),
            ],
            [
                'user_id' => 13,
                'pregunta_id' => 2,
                'respuesta_hash' => Hash::make('San Cristóbal'),
            ],

            // Médico 8 (user_id: 14)
            [
                'user_id' => 14,
                'pregunta_id' => 8,
                'respuesta_hash' => Hash::make('El Padrino'),
            ],
            [
                'user_id' => 14,
                'pregunta_id' => 3,
                'respuesta_hash' => Hash::make('Pasta'),
            ],

            // Médico 9 (user_id: 15)
            [
                'user_id' => 15,
                'pregunta_id' => 9,
                'respuesta_hash' => Hash::make('Clínica Privada'),
            ],
            [
                'user_id' => 15,
                'pregunta_id' => 4,
                'respuesta_hash' => Hash::make('Sofía'),
            ],

            // Médico 10 (user_id: 16)
            [
                'user_id' => 16,
                'pregunta_id' => 10,
                'respuesta_hash' => Hash::make('Magallanes'),
            ],
            [
                'user_id' => 16,
                'pregunta_id' => 5,
                'respuesta_hash' => Hash::make('Reyes'),
            ],

            // Médico 11 (user_id: 17)
            [
                'user_id' => 17,
                'pregunta_id' => 11,
                'respuesta_hash' => Hash::make('José'),
            ],
            [
                'user_id' => 17,
                'pregunta_id' => 6,
                'respuesta_hash' => Hash::make('Escuela Nacional'),
            ],

            // Médico 12 (user_id: 18)
            [
                'user_id' => 18,
                'pregunta_id' => 12,
                'respuesta_hash' => Hash::make('1994'),
            ],
            [
                'user_id' => 18,
                'pregunta_id' => 7,
                'respuesta_hash' => Hash::make('Rojo'),
            ],

            // Pacientes (user_id: 19-38) - 2 respuestas cada uno
            [
                'user_id' => 19,
                'pregunta_id' => 1,
                'respuesta_hash' => Hash::make('Firulais'),
            ],
            [
                'user_id' => 19,
                'pregunta_id' => 2,
                'respuesta_hash' => Hash::make('Caracas'),
            ],
            [
                'user_id' => 20,
                'pregunta_id' => 3,
                'respuesta_hash' => Hash::make('Hallacas'),
            ],
            [
                'user_id' => 20,
                'pregunta_id' => 4,
                'respuesta_hash' => Hash::make('Laura'),
            ],
            [
                'user_id' => 21,
                'pregunta_id' => 5,
                'respuesta_hash' => Hash::make('López'),
            ],
            [
                'user_id' => 21,
                'pregunta_id' => 6,
                'respuesta_hash' => Hash::make('Liceo Bolívar'),
            ],
            [
                'user_id' => 22,
                'pregunta_id' => 7,
                'respuesta_hash' => Hash::make('Morado'),
            ],
            [
                'user_id' => 22,
                'pregunta_id' => 8,
                'respuesta_hash' => Hash::make('Titanic'),
            ],
            [
                'user_id' => 23,
                'pregunta_id' => 9,
                'respuesta_hash' => Hash::make('Bufete Legal'),
            ],
            [
                'user_id' => 23,
                'pregunta_id' => 10,
                'respuesta_hash' => Hash::make('Cardenales'),
            ],
            [
                'user_id' => 24,
                'pregunta_id' => 1,
                'respuesta_hash' => Hash::make('Michi'),
            ],
            [
                'user_id' => 24,
                'pregunta_id' => 11,
                'respuesta_hash' => Hash::make('Antonio'),
            ],
            [
                'user_id' => 25,
                'pregunta_id' => 2,
                'respuesta_hash' => Hash::make('Maracay'),
            ],
            [
                'user_id' => 25,
                'pregunta_id' => 12,
                'respuesta_hash' => Hash::make('1998'),
            ],
            [
                'user_id' => 26,
                'pregunta_id' => 3,
                'respuesta_hash' => Hash::make('Pizza'),
            ],
            [
                'user_id' => 26,
                'pregunta_id' => 13,
                'respuesta_hash' => Hash::make('El Principito'),
            ],
            [
                'user_id' => 27,
                'pregunta_id' => 4,
                'respuesta_hash' => Hash::make('Miguel'),
            ],
            [
                'user_id' => 27,
                'pregunta_id' => 14,
                'respuesta_hash' => Hash::make('Profesora María'),
            ],
            [
                'user_id' => 28,
                'pregunta_id' => 5,
                'respuesta_hash' => Hash::make('Torres'),
            ],
            [
                'user_id' => 28,
                'pregunta_id' => 15,
                'respuesta_hash' => Hash::make('Margarita'),
            ],
            [
                'user_id' => 29,
                'pregunta_id' => 6,
                'respuesta_hash' => Hash::make('Colegio La Salle'),
            ],
            [
                'user_id' => 29,
                'pregunta_id' => 1,
                'respuesta_hash' => Hash::make('Pelusa'),
            ],
            [
                'user_id' => 30,
                'pregunta_id' => 7,
                'respuesta_hash' => Hash::make('Amarillo'),
            ],
            [
                'user_id' => 30,
                'pregunta_id' => 2,
                'respuesta_hash' => Hash::make('Puerto La Cruz'),
            ],
            [
                'user_id' => 31,
                'pregunta_id' => 8,
                'respuesta_hash' => Hash::make('Matrix'),
            ],
            [
                'user_id' => 31,
                'pregunta_id' => 3,
                'respuesta_hash' => Hash::make('Cachapas'),
            ],
            [
                'user_id' => 32,
                'pregunta_id' => 9,
                'respuesta_hash' => Hash::make('Tienda Familiar'),
            ],
            [
                'user_id' => 32,
                'pregunta_id' => 4,
                'respuesta_hash' => Hash::make('Daniela'),
            ],
            [
                'user_id' => 33,
                'pregunta_id' => 10,
                'respuesta_hash' => Hash::make('Leones'),
            ],
            [
                'user_id' => 33,
                'pregunta_id' => 5,
                'respuesta_hash' => Hash::make('Navarro'),
            ],
            [
                'user_id' => 34,
                'pregunta_id' => 11,
                'respuesta_hash' => Hash::make('Pedro'),
            ],
            [
                'user_id' => 34,
                'pregunta_id' => 6,
                'respuesta_hash' => Hash::make('Escuela Miranda'),
            ],
            [
                'user_id' => 35,
                'pregunta_id' => 12,
                'respuesta_hash' => Hash::make('2008'),
            ],
            [
                'user_id' => 35,
                'pregunta_id' => 7,
                'respuesta_hash' => Hash::make('Negro'),
            ],
            [
                'user_id' => 36,
                'pregunta_id' => 13,
                'respuesta_hash' => Hash::make('Harry Potter'),
            ],
            [
                'user_id' => 36,
                'pregunta_id' => 1,
                'respuesta_hash' => Hash::make('Coco'),
            ],
            [
                'user_id' => 37,
                'pregunta_id' => 14,
                'respuesta_hash' => Hash::make('Profesor Ramón'),
            ],
            [
                'user_id' => 37,
                'pregunta_id' => 2,
                'respuesta_hash' => Hash::make('Maracaibo'),
            ],
            [
                'user_id' => 38,
                'pregunta_id' => 15,
                'respuesta_hash' => Hash::make('Morrocoy'),
            ],
            [
                'user_id' => 38,
                'pregunta_id' => 3,
                'respuesta_hash' => Hash::make('Tequeños'),
            ],
        ];

        foreach ($respuestas as $respuesta) {
            DB::table('respuestas_seguridad')->insert(array_merge($respuesta, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
