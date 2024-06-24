<?php

namespace App\Events;

use App\Models\Appointment;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Listener: SendAppointmentPlannedNotificationListener
 */
class AppointmentPlannedEvent
{
    use Dispatchable;

    public function __construct(
        public Appointment $appointment,
    ) {}
}
