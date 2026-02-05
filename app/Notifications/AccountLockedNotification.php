<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountLockedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('⛔ Alerta Crítica: Cuenta Bloqueada')
                    ->greeting('Hola ' . $notifiable->nombre_completo)
                    ->line('Tu cuenta ha sido bloqueada temporalmente por seguridad tras detectar múltiples intentos fallidos de inicio de sesión.')
                    ->line('**Detalles del bloqueo:**')
                    ->line('⏰ Hora: ' . $this->details['time'])
                    ->line('📍 IP del intento: ' . $this->details['ip'])
                    ->line('🔓 Desbloqueo automático: ' . $this->details['unlock_time'])
                    ->line('Si has olvidado tu contraseña, puedes restablecerla usando el siguiente enlace:')
                    ->action('Recuperar Contraseña', route('recovery'));
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Cuenta Bloqueada',
            'message' => 'Bloqueo temporal por múltiples intentos fallidos desde IP ' . $this->details['ip'],
            'details' => $this->details
        ];
    }
}
