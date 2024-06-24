<?php

namespace Tests\Unit;

use App\Models\Coach;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class CoachTest extends TestCase
{
    public function test_when_a_coach_is_created_a_default_schedule_will_be_created(): void
    {
        $coach = Coach::factory()->create();

        $this->assertCount(
            1,
            $coach->schedules()->where([
                'day' => Carbon::MONDAY,
                'is_available' => true,
            ])->get()
        );

        $this->assertCount(
            1,
            $coach->schedules()->where([
                'day' => Carbon::MONDAY,
                'is_available' => true,
            ])->get()
        );

        $this->assertCount(
            1,
            $coach->schedules()->where([
                'day' => Carbon::MONDAY,
                'is_available' => true,
            ])->get()
        );

        $this->assertCount(
            1,
            $coach->schedules()->where([
                'day' => Carbon::TUESDAY,
                'is_available' => true,
            ])->get()
        );

        $this->assertCount(
            1,
            $coach->schedules()->where([
                'day' => Carbon::WEDNESDAY,
                'is_available' => true,
            ])->get()
        );

        $this->assertCount(
            1,
            $coach->schedules()->where([
                'day' => Carbon::THURSDAY,
                'is_available' => true,
            ])->get()
        );

        $this->assertCount(
            1,
            $coach->schedules()->where([
                'day' => Carbon::FRIDAY,
                'is_available' => true,
            ])->get()
        );

        $this->assertCount(
            1,
            $coach->schedules()->where([
                'day' => Carbon::SATURDAY,
                'is_available' => false,
            ])->get()
        );

        $this->assertCount(
            1,
            $coach->schedules()->where([
                'day' => Carbon::SUNDAY,
                'is_available' => false,
            ])->get()
        );
    }
}
