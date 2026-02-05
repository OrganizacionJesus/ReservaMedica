<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition(): array
    {
        return [
            'rol_id' => 3, // Paciente por defecto
            'correo' => $this->faker->unique()->safeEmail(),
            'password' => 'Password123!', // El mutador hash MD5 lo procesará
            'status' => 1,
            'email_verified_at' => now(),
        ];
    }
    
    public function medico()
    {
        return $this->state(function (array $attributes) {
            return [
                'rol_id' => 2,
            ];
        });
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'rol_id' => 1,
            ];
        });
    }
}
