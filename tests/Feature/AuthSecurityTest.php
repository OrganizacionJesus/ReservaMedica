<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class AuthSecurityTest extends TestCase
{
    // Usamos transacciones para revertir cambios en BD después de cada test
    use DatabaseTransactions;

    /** @test */
    public function account_locks_after_5_failed_login_attempts()
    {
        // Limpiar usuario previo si existe
        Usuario::where('correo', 'locked@test.com')->delete();

        // MD5 doble hash segun Usuario.php
        $password = 'Password123!';
        $user = Usuario::factory()->create([
            'correo' => 'locked@test.com',
            'password' => $password, 
            'rol_id' => 3,
            'status' => 1
        ]);

        for ($i = 0; $i < 5; $i++) {
            $this->post(route('login'), [
                'correo' => $user->correo,
                'password' => 'WrongPass123!'
            ]);
        }
        
        // Verificar el estado en BD
        $this->assertDatabaseHas('usuarios', [
            'id' => $user->id,
            'status' => 2 // Locked
        ]);
        
        // El 6to intento debe fallar con mensaje de bloqueo
        $response = $this->post(route('login'), [
            'correo' => $user->correo,
            'password' => 'WrongPass123!'
        ]);
        
        $response->assertSessionHasErrors(['correo']);
    }

    /** @test */
    public function logout_invalidates_session()
    {
        Usuario::where('correo', 'logout@test.com')->delete();
        $user = Usuario::factory()->create([
            'correo' => 'logout@test.com',
            'password' => 'Password123!', 
            'status' => 1
        ]);
        
        $this->actingAs($user);
        
        $session_id_before = Session::getId();
        
        // Seguir redirecciones si es necesario, pero logout debe ser POST y redirigir
        $response = $this->post(route('logout'));
        
        $response->assertRedirect(route('home'));
        $this->assertGuest();
        
        // ID debe cambiar
        $this->assertNotEquals($session_id_before, Session::getId());
    }

    /** @test */
    public function anti_enumeration_in_login()
    {
        $response = $this->post(route('login'), [
            'correo' => 'nonexistent_random_email@example.com',
            'password' => 'Password123!'
        ]);
        
        $response->assertSessionHasErrors(['correo']);
        
        // Obtener el error de la sesión
        $errors = session('errors');
        $errorMsg = $errors->first('correo');
        
        // Validar mensaje genérico
        $this->assertStringContainsString('credenciales', $errorMsg);
    }

    /** @test */
    public function anti_enumeration_in_recovery()
    {
        $response = $this->postJson(route('recovery.send-email'), [
            'email' => 'nonexistent_random@example.com'
        ]);
        
        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
    }

    /** @test */
    public function password_reset_uses_correct_table_and_policy()
    {
        Usuario::where('correo', 'reset@test.com')->delete();
        DB::table('password_reset_tokens')->where('email', 'reset@test.com')->delete();
        
        $user = Usuario::factory()->create(['correo' => 'reset@test.com', 'status' => 1]);
        $token = Str::random(64);
        
        DB::table('password_reset_tokens')->insert([
            'email' => $user->correo,
            'token' => $token,
            'created_at' => now()
        ]);

        // 1. Password débil
        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->correo,
            'password' => 'weak',
            'password_confirmation' => 'weak'
        ]);
        $response->assertSessionHasErrors(['password']);

        // 2. Password fuerte
        $newPass = 'NewStrongPass1!';
        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->correo,
            'password' => $newPass,
            'password_confirmation' => $newPass
        ]);
        
        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success');
        
        // Verificar cambio en BD
        $user->refresh();
        $this->assertEquals(md5(md5($newPass)), $user->password);
        
        // Token eliminado
        $this->assertDatabaseMissing('password_reset_tokens', [
            'email' => $user->correo
        ]);
    }
}
