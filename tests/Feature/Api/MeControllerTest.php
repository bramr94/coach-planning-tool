<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class MeControllerTest extends TestCase
{
    protected array $jsonStructure = [
        'id',
        'name',
        'email',
        'appointments' => [],
        'created_at',
        'updated_at',
    ];

    public function test_user_can_retrieve_personal_information(): void
    {
        $response = $this->actingAs($this->user())
            ->getJson(route('api.me'))
            ->assertOk();

        $response->assertJsonStructure([
            'data' => $this->jsonStructure,
        ]);
    }
}
