<?php

namespace Tests\Feature;

use App\Models\Usuario;
use App\Models\KnownDevice;
use App\Models\HistorialPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use App\Notifications\NewDeviceLoginNotification;
use App\Notifications\PasswordChangedNotification;
use App\Notifications\AccountLockedNotification;
use Tests\TestCase;

class AuthNotificationsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Disable CSRF for easier testing
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        
        // Seed Roles for Foreign Key constraints
        $this->seed(\Database\Seeders\RolesTableSeeder::class);
    }

    /** @test */
    public function it_sends_notification_on_new_device_login()
    {
        Notification::fake();

        $user = Usuario::factory()->create([
            'password' => md5(md5('Password123!')),
            'rol_id' => 3,
            'status' => 1
        ]);

        $response = $this->post('/login', [
            'correo' => $user->correo,
            'password' => 'Password123!',
            'rol' => 'paciente'
        ]);

        $response->assertRedirect();
        
        Notification::assertSentTo(
            $user,
            NewDeviceLoginNotification::class
        );

        $this->assertDatabaseHas('known_devices', [
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function it_does_not_send_notification_on_known_device_login()
    {
        Notification::fake();

        $user = Usuario::factory()->create([
            'password' => md5(md5('Password123!')),
            'rol_id' => 3,
            'status' => 1
        ]);

        // Pre-register device
        KnownDevice::create([
            'user_id' => $user->id,
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Symfony',
            'last_login_at' => now()->subDay()
        ]);

        $response = $this->post('/login', [
            'correo' => $user->correo,
            'password' => 'Password123!',
            'rol' => 'paciente'
        ], ['User-Agent' => 'Symfony', 'REMOTE_ADDR' => '127.0.0.1']);

        $response->assertRedirect();
        
        Notification::assertNotSentTo(
            $user,
            NewDeviceLoginNotification::class
        );
    }

    /** @test */
    public function it_prevents_password_reuse_from_history()
    {
        Notification::fake();

        $user = Usuario::factory()->create([
            'password' => md5(md5('OldPass1!')),
            'rol_id' => 3,
            'status' => 1
        ]);

        // Add to history
        HistorialPassword::create([
            'user_id' => $user->id,
            'password_hash' => md5(md5('OldPass1!')),
            'status' => false
        ]);

        // Mock Reset Token
        $token = 'valid-token';
        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->insert([
            'email' => $user->correo,
            'token' => $token,
            'created_at' => now()
        ]);

        // Try to reset to SAME password
        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => $user->correo,
            'password' => 'OldPass1!',
            'password_confirmation' => 'OldPass1!'
        ]);

        $response->assertSessionHasErrors(); // custom error message about history
        $response->assertSessionHas('error', 'La nueva contraseña no puede ser una de las últimas 5 que has usado. Por seguridad, utiliza una diferente.');
    }

    /** @test */
    public function it_sends_notification_on_password_change()
    {
        Notification::fake();

        $user = Usuario::factory()->create([
            'password' => md5(md5('OldPass1!')),
            'rol_id' => 3,
            'status' => 1
        ]);

        // Mock Reset Token
        $token = 'valid-token';
        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->insert([
            'email' => $user->correo,
            'token' => $token,
            'created_at' => now()
        ]);

        // Reset to NEW password
        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => $user->correo,
            'password' => 'NewPass1!',
            'password_confirmation' => 'NewPass1!'
        ]);

        $response->assertRedirect(route('login'));
        
        Notification::assertSentTo(
            $user,
            PasswordChangedNotification::class
        );
    }
}
