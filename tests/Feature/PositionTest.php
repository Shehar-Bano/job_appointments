<?php

namespace Tests\Feature;

use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PositionTest extends TestCase
{
    use RefreshDatabase;

    public function it_can_create_a_position()
    {
        // Create a new user and authenticate
        $user = User::factory()->create(); // Create a user
        $this->actingAs($user, 'api'); // Act as the authenticated user

        // Prepare valid data for creating a position
        $data = [
            'title' => 'Software Engineer',
            'job_type' => 'full_time', // Use valid enum value
            'requirement' => [ // Pass as an array
                'education' => "Bachelor's Degree",
                'experience' => '9 years',
                'skills' => 'dicta, sent, consequent', // Ensure this matches what's stored
            ],
            'status' => 'open',
            'description' => 'Sit omnis nemo et enim quia sed. Adipisci et dolorem quas sunt.',
            'post_date' => '2018-10-12',
        ];

        // Create the position
        $response = $this->postJson('/api/positions', $data);

        // Assert the response
        $response->assertJson([
            'success' => true,
            'data' => 'data stored successfully',
        ]);

        // Assert the position is created in the database
        $this->assertDatabaseHas('positions', [
            'title' => 'Software Engineer',
            'job_type' => 'full_time',
            'requirement' => json_encode([ // Ensure this matches what is stored in the database
                'education' => "Bachelor's Degree",
                'experience' => '9 years',
                'skills' => 'dicta, sent, consequent',
            ]),
            'status' => 'open',
            'description' => 'Sit omnis nemo et enim quia sed. Adipisci et dolorem quas sunt.',
            'post_date' => '2018-10-12',
        ]);
    }

    /** @test */
    public function it_can_fetch_all_positions()
    {
        // Create a new user
        $user = User::factory()->create();
        $this->actingAs($user, 'api'); // Act as authenticated user

        // Create some positions
        Position::factory()->count(3)->create();

        // Send request to fetch all positions
        $response = $this->getJson('/api/positions');

        // Assert the response
        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                    'job_type',
                    'requirement',
                    'description',
                    'post_date',
                ],
            ]);
    }

    /** @test */
    public function it_can_fetch_a_specific_position()
    {
        // Create a new user
        $user = User::factory()->create();
        $this->actingAs($user, 'api'); // Act as authenticated user

        // Create a position
        $position = Position::factory()->create([
            'title' => 'Software Engineer',
            'job_type' => 'full_time',
        ]);

        // Send request to fetch the position
        $response = $this->getJson('/api/positions/'.$position->id);

        // Assert the response
        $response->assertStatus(200)
            ->assertJson([
                'id' => $position->id,
                'title' => 'Software Engineer',
                'job_type' => 'full_time',
            ]);
    }

    /** @test */
    /** @test */
    public function it_can_update_a_position()
    {
        // Create a user and authenticate
        $user = User::factory()->create(); // Create a user
        $this->actingAs($user, 'api'); // Act as the authenticated user

        $position = Position::factory()->create(); // Create a position for testing

        // Prepare valid update data
        $updatedData = [
            'title' => 'Senior Software Engineer',
            'job_type' => 'full_time',
            'requirement' => ["Master's degree", '5+ years experience'],
            'description' => 'Responsible for leading the development team.',
            'post_date' => now()->toDateString(), // Ensure this is a valid date
        ];

        // Send request to update the position
        $response = $this->putJson('/api/positions/'.$position->id, $updatedData);

        // Assert the response
        $response->assertStatus(200)
            ->assertJson(['message' => 'Job updated successfully']);

        // Assert the position is updated in the database
        $this->assertDatabaseHas('positions', [
            'id' => $position->id,
            'title' => 'Senior Software Engineer',
            'job_type' => 'full_time', // Check for the valid enum value
            'requirement' => json_encode(["Master's degree", '5+ years experience']),
            'description' => 'Responsible for leading the development team.',
            'post_date' => now()->toDateString(),
        ]);
    }

    /** @test */
    public function it_can_delete_a_position()
    {
        // Create a new user
        $user = User::factory()->create();
        $this->actingAs($user, 'api'); // Act as authenticated user

        // Create a position
        $position = Position::factory()->create();

        // Send request to delete the position
        $response = $this->deleteJson('/api/positions/'.$position->id);

        // Assert the response
        $response->assertStatus(200)
            ->assertJson(['message' => 'Job deleted successfully']);

        // Assert the position is deleted from the database
        $this->assertDatabaseMissing('positions', [
            'id' => $position->id,
        ]);
    }

    /** @test */
    public function it_can_change_position_status()
    {
        // Create a new user
        $user = User::factory()->create();
        $this->actingAs($user, 'api'); // Act as authenticated user

        // Create a position
        $position = Position::factory()->create(['status' => 'open']);

        // Send request to change the status
        $response = $this->postJson('/api/positions/change-status/'.$position->id);

        // Assert the response
        $response->assertStatus(200);

        // Fetch the position again to verify status change
        $position->refresh(); // Refresh the instance to get the updated values
        $this->assertEquals('close', $position->status); // Check if status has changed

        // Change it back to 'open'
        $response = $this->postJson('/api/positions/change-status/'.$position->id);
        $position->refresh();
        $this->assertEquals('open', $position->status); // Check if status has changed back
    }
}
