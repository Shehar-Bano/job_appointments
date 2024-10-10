<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        // Create a user in the database
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // Ensure the password is hashed
        ]);

        // Attempt to log in with valid credentials
        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
    }
}
