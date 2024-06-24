<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Coach;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        $coach = Coach::factory()->create();

        return [
            'date' => Carbon::now(),
            'start_time' => $now = Carbon::now(),
            'end_time' => $now->addHour(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'coach_id' => $coach->id,
            'schedule_id' => $coach->schedules()->inRandomOrder()->first()->id,
            'user_id' => User::factory(),
        ];
    }
}
