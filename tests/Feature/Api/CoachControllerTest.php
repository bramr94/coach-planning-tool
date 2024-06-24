<?php

namespace Tests\Feature\Api;

use App\Models\Appointment;
use App\Models\Coach;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class CoachControllerTest extends TestCase
{
    protected array $jsonStructure = [
        'id',
        'name',
        'email',
        'schedule' => [
            [
                'id',
                'coach_id',
                'day',
                'day_name',
                'start_time',
                'end_time',
                'is_available',
                'appointments' => [],
                'created_at',
                'updated_at',
            ],
        ],
        'created_at',
        'updated_at',
    ];

    public function test_user_can_retrieve_all_coaches(): void
    {
        Coach::factory()->count(5)->create();

        $response = $this->actingAs($this->user())
            ->getJson(route('api.coaches.index'))
            ->assertOk();

        $response->assertJsonStructure([
            'data' => [$this->jsonStructure],
        ]);

        $this->assertCount(5, $response->json('data'));
    }

    public function test_user_can_retrieve_a_specific_coach(): void
    {
        $coaches = Coach::factory()->count(5)->create();

        $coach = $coaches->random();
        $response = $this->actingAs($this->user())
            ->getJson(route('api.coaches.show', [$coach]))
            ->assertOk();

        $response->assertJsonStructure([
            'data' => $this->jsonStructure,
        ]);

        $this->assertEquals($response->json('data.id'), $coach->id);
    }

    public function test_coach_appointments_are_shown_if_coach_has_appointments(): void
    {
        // Set default to a weekday to make testing easier.
        Carbon::setTestNow('2024-06-20');
        $coach = Coach::factory()->create();

        Appointment::factory([
            'coach_id' => $coach->id,
            'date' => now(),
            'start_time' => '08:30:00',
            'end_time' => '09:00:00',
            'schedule_id' => $coach->schedules()->getScheduleFromDate(now())->first()->id,
        ])->create();

        $response = $this->actingAs($this->user())
            ->getJson(route('api.coaches.show', [
                'coach' => $coach,
            ]).'?start_date='.Carbon::now()->startOfWeek().'&end_date='.Carbon::now()->endOfWeek())
            ->assertOk();

        $response->assertJsonStructure([
            'data' => $this->jsonStructure,
        ]);

        $this->assertNotEmpty($response->json('data.schedule.4.appointments'));
        $this->assertEmpty($response->json('data.schedule.5.appointments'));
    }
}
