<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthenticationControllerTest extends TestCase
{
    public function test_user_can_login(): void
    {
        $user = User::factory()->create();

        $this->postJson(route('api.login', [
            'email' => $user->email,
            'password' => 'password',
        ]))
            ->assertOk();

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_type' => User::class,
            'tokenable_id' => $user->id,
        ]);
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $user = User::factory()->create();

        $this->postJson(route('api.login', [
            'email' => $user->email,
            'password' => 'incorrect-password',
        ]))
            ->assertStatus(401);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_type' => User::class,
            'tokenable_id' => $user->id,
        ]);
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $this->postJson(route('api.login', [
            'email' => $user->email,
            'password' => 'password',
        ]))
            ->assertOk();

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_type' => User::class,
            'tokenable_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->postJson(route('api.logout'))
            ->assertOk();

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_type' => User::class,
            'tokenable_id' => $user->id,
        ]);
    }
}
