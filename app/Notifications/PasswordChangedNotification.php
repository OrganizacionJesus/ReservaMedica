<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $time;

    public function __construct()
    {
        $this->time = now()->format('d/m/Y H:i:s');
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('🔐 Tu contraseña ha sido cambiada')
                    ->greeting('Hola ' . $notifiable->nombre_completo)
                    ->line('Te informamos que la contraseña de tu cuenta fue actualizada exitosamente el ' . $this->time . '.')
                    ->line('Si no realizaste este cambio, por favor contacta a soporte inmediatamente y recupera tu cuenta.')
                    ->action('Recuperar Cuenta', route('recovery'));
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Contraseña Actualizada',
            'message' => 'Tu contraseña fue modificada el ' . $this->time,
            'time' => $this->time
        ];
    }
}
