<?php

namespace App\Notifications;

use App\Models\Appointment;
use App\Models\Coach;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentCoachNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Appointment $appointment) {}

    /**
     * @return string[]
     */
    public function via(Coach $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(Coach $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting("Hello {$notifiable->name},")
            ->line("{$this->appointment->user->name} has scheduled an appointment with you.")
            ->line("Date: {$this->appointment->date->format('d-m-Y')} from {$this->appointment->start_time} to {$this->appointment->end_time}.");
    }
}
