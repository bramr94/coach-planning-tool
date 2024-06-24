<?php

namespace App\Observers;

use App\Models\Coach;
use Illuminate\Support\Carbon;

class CoachObserver
{
    /**
     * Create a default schedule for the coach.
     */
    public function created(Coach $coach): void
    {
        $coach->schedules()->createMany([
            [
                'day' => Carbon::MONDAY,
                'start_time' => '08:30',
                'end_time' => '17:00',
                'is_available' => true,
            ], [
                'day' => Carbon::TUESDAY,
                'start_time' => '08:30',
                'end_time' => '17:00',
                'is_available' => true,
            ], [
                'day' => Carbon::WEDNESDAY,
                'start_time' => '08:30',
                'end_time' => '17:00',
                'is_available' => true,
            ], [
                'day' => Carbon::THURSDAY,
                'start_time' => '08:30',
                'end_time' => '17:00',
                'is_available' => true,
            ], [
                'day' => Carbon::FRIDAY,
                'start_time' => '08:30',
                'end_time' => '17:00',
                'is_available' => true,
            ], [
                'day' => Carbon::SATURDAY,
                'is_available' => false,
            ], [
                'day' => Carbon::SUNDAY,
                'is_available' => false,
            ],
        ]);
    }
}
