<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RateLimitTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_is_rate_limited()
    {
        User::factory()->create([
            'email' => 'test@test.com',
            'password' => 'password',
        ]);

        for ($i = 0; $i < 5; $i++) {
            $response = $this->postJson('/api/login', [
                'email' => 'test@test.com',
                'password' => 'password',
            ]);
            $response->assertStatus(200);
        }

        $response = $this->postJson('/api/login', [
            'email' => 'test@test.com',
            'password' => 'password',
        ]);
        $response->assertStatus(429);
    }



    public function test_authenticated_task_requests_are_rate_limited_per_user()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum');

        for ($i = 0; $i < 60; $i++) {
            $response = $this->getJson('/api/tasks');
            $response->assertStatus(200);
        }
        $response = $this->getJson('/api/tasks');
        $response->assertStatus(429);
    }
}
