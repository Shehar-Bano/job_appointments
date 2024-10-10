<?php

namespace Tests\Feature;

use App\Models\Slot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SlotTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_slot()
    {
        $user = User::factory()->create(); // Create a user
        $this->actingAs($user, 'api'); // Act as the authenticated user

        $response = $this->postJson('/api/slots', [
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Slot Created Successfully',
            ]);

        $this->assertDatabaseHas('slots', [
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
        ]);
    }

    /** @test */
    public function it_can_fetch_a_slot()
    {
        $user = User::factory()->create(); // Create a user
        $this->actingAs($user, 'api'); // Act as the authenticated user

        $slot = Slot::factory()->create([
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
        ]);

        $response = $this->getJson('/api/slots/'.$slot->id);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'start_time' => '10:00:00',
                    'end_time' => '11:00:00',
                ],
                'success' => true,
            ]);
    }

    /** @test */
    public function it_can_update_a_slot()
    {
        $user = User::factory()->create(); // Create a user
        $this->actingAs($user, 'api'); // Act as the authenticated user

        $slot = Slot::factory()->create([
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
        ]);

        $response = $this->putJson('/api/slots/'.$slot->id, [
            'start_time' => '12:00:00',
            'end_time' => '13:00:00',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Slot Updated Successfully',
            ]);

        $this->assertDatabaseHas('slots', [
            'start_time' => '12:00:00',
            'end_time' => '13:00:00',
        ]);
    }

    public function it_can_delete_a_slot()
    {
        $slot = Slot::factory()->create();

        $this->assertDatabaseHas('slots', [
            'id' => $slot->id,
        ]);

        $response = $this->deleteJson('/api/slots/'.$slot->id);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Slot Deleted Successfully',
                'success' => true,
            ]);

        // Dump the current state of the slots table for debugging
        dump(Slot::all()->toArray());

        $this->assertDatabaseMissing('slots', [
            'id' => $slot->id,
        ]);
    }

    // public function test_it_can_list_all_slots()
    // {
    //     // Create a new user using factory
    //     $user = User::factory()->create();

    //     // Use actingAs to authenticate the user
    //     $this->actingAs($user, 'api'); // Act as authenticated user

    //     // Create some slots for testing
    //     Slot::factory()->count(3)->create();

    //     // Send the request to list all slots
    //     $response = $this->getJson('/api/slots'); // Adjust endpoint as needed

    //     // Assert that the response status is 200 OK
    //     $response->assertStatus(200)
    //              ->assertJsonStructure([
    //                  'success',
    //                  'data' => [
    //                      '*' => [
    //                          'start_time',
    //                          'end_time',
    //                      ]
    //                  ]
    //              ]);
    // }

}
