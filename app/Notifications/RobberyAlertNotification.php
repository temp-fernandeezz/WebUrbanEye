<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RobberyAlertNotification extends Notification
{
    use Queueable;

    protected $report;

    public function __construct($report)
    {
        $this->report = $report;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast']; // Ou apenas 'database' se não estiver usando notificações em tempo real
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Denúncia de Assalto Próximo',
            'message' => 'Recebemos uma denúncia de assaltos próximo à sua casa. Poderia confirmar?',
            'report_id' => $this->report->id,
        ];
    }
}
