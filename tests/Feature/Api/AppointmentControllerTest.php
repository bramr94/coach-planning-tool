<?php

namespace Tests\Feature\Api;

use App\Models\Coach;
use App\Models\User;
use App\Notifications\AppointmentCoachNotification;
use App\Notifications\AppointmentUserNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AppointmentControllerTest extends TestCase
{
    public function test_user_can_store_appointment(): void
    {
        Notification::fake();

        // Set date so testing is easier.
        Carbon::setTestNow('2024-06-17');

        $user = $this->user();
        $coach = Coach::factory()->create();

        $this->actingAs($user)
            ->postJson(route('api.appointments.store'), [
                'coach_id' => $coach->id,
                'date' => now()->format('Y-m-d'),
                'start_time' => '08:30:00',
                'end_time' => '09:00:00',
            ])
            ->assertCreated();

        $this->assertDatabaseCount('appointments', 1);
        $this->assertDatabaseHas('appointments', [
            'coach_id' => $coach->id,
            'user_id' => $user->id,
        ]);

        Notification::assertSentTo($user, AppointmentUserNotification::class);
        Notification::assertSentTo($coach, AppointmentCoachNotification::class);
    }

    public function test_appointments_cannot_be_planned_on_dates_the_coach_is_not_working(): void
    {
        Notification::fake();

        // Set date so testing is easier.
        Carbon::setTestNow('2024-06-17');

        $user = $this->user();
        $coach = Coach::factory()->create();

        $this->actingAs($user)
            ->postJson(route('api.appointments.store'), [
                'coach_id' => $coach->id,
                // Saturday
                'date' => now()->addDays(6)->format('Y-m-d'),
                'start_time' => '08:30:00',
                'end_time' => '09:00:00',
            ])
            ->assertStatus(422);

        $this->assertDatabaseCount('appointments', 0);

        Notification::assertNothingSentTo($user);
        Notification::assertNothingSentTo($coach);
    }

    public function test_appointments_cannot_overlap(): void
    {
        Notification::fake();

        // Set date so testing is easier.
        Carbon::setTestNow('2024-06-17');

        $user = $this->user();
        $coach = Coach::factory()->create();

        $coach->appointments()
            ->create([
                'user_id' => User::factory()->create()->id,
                'schedule_id' => $coach->schedules()->getScheduleFromDate(now())->first()->id,
                'date' => now()->addDay()->format('Y-m-d'),
                'start_time' => '09:00:00',
                'end_time' => '10:00:00',
            ]);

        $this->actingAs($user)
            ->postJson(route('api.appointments.store'), [
                'coach_id' => $coach->id,
                'date' => now()->addDay()->format('Y-m-d'),
                'start_time' => '08:30:00',
                'end_time' => '09:30:00',
            ])
            ->assertStatus(422);

        $this->assertDatabaseCount('appointments', 1);

        Notification::assertNothingSentTo($user);
        Notification::assertNothingSentTo($coach);
    }

    public function test_if_coach_does_not_exist_we_get_a_validation_error(): void
    {
        // Set date so testing is easier.
        Carbon::setTestNow('2024-06-17');

        $user = $this->user();
        $coach = Coach::factory()->create();

        $this->actingAs($user)
            ->postJson(route('api.appointments.store'), [
                'coach_id' => $coach->id - 1,
                'date' => now()->format('Y-m-d'),
                'start_time' => '08:30:00',
                'end_time' => '09:00:00',
            ])
            ->assertStatus(422);
    }
}
