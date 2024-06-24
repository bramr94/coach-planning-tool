<?php

namespace App\Http\Controllers\Api;

use App\Events\AppointmentPlannedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AppointmentStoreRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Coach;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AppointmentController extends Controller
{
    public function store(AppointmentStoreRequest $request): AppointmentResource
    {
        $data = $request->validated();

        $coach = Coach::query()
            ->whereId($data['coach_id'])
            // We can't use the "Arrow Functions" because phpstan will fail if we do.
            ->with('schedules', function (Builder|HasMany $query) use ($data) {
                /** @var Schedule $query */
                $query->getScheduleFromDate($data['date']);
            })
            ->first();

        $appointment = $coach->appointments()->create([
            'schedule_id' => $coach->schedules->first()->id,
            'user_id' => $request->user()->id,
            'date' => $data['date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
        ]);

        $appointment->load('coach', 'user');

        AppointmentPlannedEvent::dispatch($appointment);

        return AppointmentResource::make($appointment);
    }
}
