<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BloqueCreado extends Notification
{
    use Queueable;

    public $bloque;

    public function __construct($bloque)
    {
        $this->bloque = $bloque;
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Se ha creado un nuevo bloque.')
            ->action('Ver Bloque', url('/bloques/' . $this->bloque->id))
            ->line('¡Gracias por usar nuestra aplicación!');
    }

    public function toArray($notifiable)
    {
        return [
            'bloque_id' => $this->bloque->id,
        ];
    }
}
s