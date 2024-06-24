<?php

namespace App\Listeners;

use App\Events\AppointmentPlannedEvent;
use App\Notifications\AppointmentCoachNotification;
use App\Notifications\AppointmentUserNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAppointmentPlannedNotificationListener implements ShouldQueue
{
    /**
     * Send a notification to the user and the coach.
     */
    public function handle(AppointmentPlannedEvent $event): void
    {
        $event->appointment->user->notify(new AppointmentUserNotification($event->appointment));

        $event->appointment->coach->notify(new AppointmentCoachNotification($event->appointment));
    }
}
