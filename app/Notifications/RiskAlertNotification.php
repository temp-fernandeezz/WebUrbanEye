<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class RiskAlertNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Atenção!',
            'message' => 'Você está em uma área com alta incidência de: ' . $this->type . '. Pedimos que tome cuidado.',
        ];
    }

    public function toExpoPush($notifiable)
    {
        // Formato da notificação push (supondo que o token do dispositivo do usuário esteja salvo)
        return [
            'to' => $notifiable->expo_push_token,
            'sound' => 'default',
            'title' => 'Atenção!',
            'body' => 'Você está em uma área com alta incidência de: ' . $this->type . '. Pedimos que tome cuidado.',
            'data' => ['type' => $this->type],
        ];
    }
}
