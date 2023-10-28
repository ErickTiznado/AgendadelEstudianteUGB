<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Bloque; // Importa el modelo Bloque

class BlockReminder extends Notification
{
    use Queueable;
    private $bloque; // Variable para almacenar el bloque

    public function __construct(Bloque $bloque)
    {
        $this->bloque = $bloque;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Tienes un bloque próximo: ' . $this->bloque->titulo)
                    ->action('Ver detalles', url('/')) // Modifica la URL si es necesario
                    ->line('¡No te lo pierdas!');
    }

    public function toArray($notifiable)
    {
        return [
            'bloque_id' => $this->bloque->id,
            'titulo' => $this->bloque->titulo
        ];
    }
}
