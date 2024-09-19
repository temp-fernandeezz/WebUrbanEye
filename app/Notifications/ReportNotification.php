<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ReportNotification extends Notification
{
    private $report;

    public function __construct($report)
    {
        $this->report = $report;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Há uma nova denúncia de assalto.')
            ->action('Confirmar Denúncia', url('/reports/confirm/' . $this->report->id))
            ->line('Por favor, confirme se o evento está realmente acontecendo.');
    }
}
