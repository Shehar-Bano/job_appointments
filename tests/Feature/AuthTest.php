<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_register_a_user(): void
    {
        $response = $this->postJson('/auth/signup', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'access_token', 'token_type', 'expires_in'
                 ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);
    }

    /** @test */
    public function it_can_login_a_user(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password')
        ]);

        $response = $this->postJson('/auth/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'access_token', 'token_type', 'expires_in'
                 ]);
    }

    /** @test */
    public function it_can_logout_a_user(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password')
        ]);

        // Login to get the token
        $token = auth('api')->attempt(['email' => 'test@example.com', 'password' => 'password']);

        $this->withHeaders(['Authorization' => 'Bearer ' . $token])
             ->postJson('/logout')
             ->assertStatus(200)
             ->assertJson(['message' => 'Successfully logged out']);
    }

    /** @test */
    public function it_can_fetch_authenticated_user_details(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $token = auth('api')->attempt(['email' => $user->email, 'password' => 'password']);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                         ->postJson('/me');

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $user->getKey(),
                     'email' => $user->getAttribute('email') ?? '' // Fallback to empty string if null
                 ]);
    }
}
