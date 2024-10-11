<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Slot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SlotTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_fetch_a_slot(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        /** @var Slot $slot */ // Explicitly hint that $slot is a Slot instance
        $slot = Slot::factory()->create([
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
        ]);

        $response = $this->getJson('/api/slots/' . $slot->id); // Access $slot->id safely

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
    public function it_can_update_a_slot(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        /** @var Slot $slot */
        $slot = Slot::factory()->create([
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
        ]);

        $response = $this->putJson('/api/slots/' . $slot->id, [ // Safely access $slot->id
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

    /** @test */
    public function it_can_delete_a_slot(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        /** @var Slot $slot */
        $slot = Slot::factory()->create();

        $this->assertDatabaseHas('slots', ['id' => $slot->id]); // Safely access $slot->id

        $response = $this->deleteJson('/api/slots/' . $slot->id); // Safely access $slot->id

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Slot Deleted Successfully',
                     'success' => true,
                 ]);

        $this->assertDatabaseMissing('slots', ['id' => $slot->id]); // Safely access $slot->id
    }
}
