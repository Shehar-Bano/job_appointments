<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_register_a_user()
    {
        $response = $this->postJson('/api/auth/signup', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token', 'token_type', 'expires_in',
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    /** @test */
    public function it_can_login_a_user()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token', 'token_type', 'expires_in',
            ]);
    }

    /** @test */
    public function it_can_logout_a_user()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Login to get the token
        $token = auth('api')->attempt(['email' => 'test@example.com', 'password' => 'password']);
        $this->withHeaders(['Authorization' => 'Bearer '.$token])
            ->postJson('/api/logout')
            ->assertStatus(200)
            ->assertJson(['message' => 'Successfully logged out']);
    }

    /** @test */
    public function it_can_fetch_authenticated_user_details()
    {
        $user = User::factory()->create();

        $token = auth('api')->attempt(['email' => $user->email, 'password' => 'password']);
        $response = $this->withHeaders(['Authorization' => 'Bearer '.$token])
            ->postJson('/api/me');

        $response->assertStatus(200)
            ->assertJson(['id' => $user->id, 'email' => $user->email]);
    }
}
