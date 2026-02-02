<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetodoPagoTableSeeder extends Seeder
{
    public function run(): void
    {
        $metodos = [
            [
                'nombre' => 'Efectivo (Bolívares)',
                'descripcion' => 'Pago en efectivo en moneda nacional',
                'status' => true,
            ],
            [
                'nombre' => 'Efectivo (Dólares)',
                'descripcion' => 'Pago en efectivo en dólares estadounidenses',
                'status' => true,
            ],
            [
                'nombre' => 'Transferencia Bancaria',
                'descripcion' => 'Transferencia electrónica entre cuentas bancarias venezolanas',
                'status' => true,
            ],
            [
                'nombre' => 'Pago Móvil',
                'descripcion' => 'Pago a través de plataforma de pago móvil interbancario',
                'status' => true,
            ],
            [
                'nombre' => 'Zelle',
                'descripcion' => 'Transferencia internacional vía Zelle',
                'status' => true,
            ],
            [
                'nombre' => 'PayPal',
                'descripcion' => 'Pago internacional vía PayPal',
                'status' => true,
            ],
            [
                'nombre' => 'Tarjeta de Débito',
                'descripcion' => 'Pago con tarjeta de débito nacional',
                'status' => true,
            ],
            [
                'nombre' => 'Tarjeta de Crédito',
                'descripcion' => 'Pago con tarjeta de crédito nacional o internacional',
                'status' => true,
            ],
            [
                'nombre' => 'Punto de Venta',
                'descripcion' => 'Pago mediante punto de venta (POS)',
                'status' => true,
            ],
            [
                'nombre' => 'Binance Pay',
                'descripcion' => 'Pago con criptomonedas a través de Binance',
                'status' => true,
            ],
        ];

        foreach ($metodos as $metodo) {
            DB::table('metodo_pago')->insert(array_merge($metodo, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
