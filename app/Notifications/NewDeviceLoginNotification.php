<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewDeviceLoginNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Also saving to database notifications
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('⚠️ Alerta de Seguridad: Nuevo inicio de sesión')
                    ->greeting('Hola ' . $notifiable->nombre_completo)
                    ->line('Hemos detectado un inicio de sesión en tu cuenta desde un dispositivo que no habíamos visto antes.')
                    ->line('**Detalles del acceso:**')
                    ->line('📅 Fecha: ' . $this->details['time'])
                    ->line('📍 IP: ' . $this->details['ip'])
                    ->line('💻 Dispositivo: ' . $this->details['device'])
                    ->line('Si fuiste tú, puedes ignorar este mensaje. Si no reconoces esta actividad, te recomendamos cambiar tu contraseña inmediatamente.')
                    ->action('Revisar Actividad', route('login'));
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Nuevo dispositivo detectado',
            'message' => 'Inicio de sesión desde IP: ' . $this->details['ip'],
            'ip' => $this->details['ip'],
            'device' => $this->details['device'],
            'time' => $this->details['time']
        ];
    }
}
