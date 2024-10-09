<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PageResponseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_home_page_returns_successful_response()
    {
        // Send a GET request to the home page (replace '/' with your desired route)
        $response = $this->get('/');

        // Assert that the response has a 200 status code (OK)
        $response->assertStatus(200);
    }

    /** @test */
    public function test_login_page_returns_successful_response()
{
    // Create a user with known credentials
    $user = User::factory()->create([
        'email' => 'your_email@example.com', // Adjust to match your expectations
        'password' => bcrypt('password'), // Ensure the password is hashed
    ]);

    // Make a POST request to the login route with valid credentials
    $response = $this->post('/api/auth/login', [
        'email' => 'your_email@example.com', // Use the same email
        'password' => 'password', // Use the same password
    ]);

    // Assert that the response is successful (200 or redirect)
    $response->assertStatus(200); // Adjust to assertStatus(302) if it redirects after login
}

    /** @test */
    public function test_non_existing_page_returns_404()
    {
        // Send a GET request to a non-existing route
        $response = $this->get('/non-existing-route');

        // Assert that the response has a 404 status code (Not Found)
        $response->assertStatus(404);
    }

    /** @test */
    /** @test */
    public function test_authenticated_page_returns_success_when_logged_in()
    {
        // Create a user
        $user = User::factory()->create(); // Use your user factory

        // Log in the user
        $this->actingAs($user, 'sanctum'); // Ensure you specify the correct guard

        // Send a GET request to the protected route
        $response = $this->get('/api/manage-appointment/list');

        // Assert that the response is successful (200)
        $response->assertStatus(200);
    }

    // public function test_authenticated_page_returns_unauthorized_when_not_logged_in()
    // {
    //     // Send a GET request to the protected API route without being logged in
    //     $response = $this->get('/api/manage-appointment/list');

    //     // Assert that the response is a 401 Unauthorized
    //     $response->assertStatus(401);
    // }

}
