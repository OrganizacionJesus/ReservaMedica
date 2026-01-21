<?php

namespace App\Notifications\Admin;

use App\Models\Medico;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NuevoMedicoRegistrado extends Notification
{
    use Queueable;

    protected $medico;
    protected $registradoPor;

    public function __construct(Medico $medico, $registradoPor = 'Root')
    {
        $this->medico = $medico;
        $this->registradoPor = $registradoPor;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nuevo Médico Registrado - ' . config('app.name'))
            ->greeting('¡Hola Administrador!')
            ->line('Se ha registrado un nuevo médico en el sistema.')
            ->line('**Detalles del Médico:**')
            ->line('Nombre: Dr. ' . $this->medico->primer_nombre . ' ' . $this->medico->primer_apellido)
            ->line('Documento: ' . $this->medico->tipo_documento . '-' . $this->medico->numero_documento)
            ->line('Registrado por: ' . $this->registradoPor)
            ->action('Ver Perfil', url('/medicos/' . $this->medico->id))
            ->line('El médico ya puede acceder al sistema.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'titulo' => 'Nuevo Médico Registrado',
            'mensaje' => 'Dr. ' . $this->medico->primer_nombre . ' ' . $this->medico->primer_apellido . ' fue registrado en el sistema',
            'tipo' => 'success',
            'link' => url('/medicos/' . $this->medico->id),
            'medico_id' => $this->medico->id
        ];
    }
}
