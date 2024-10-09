<?php

namespace Tests\Feature;

use App\Models\AppointmentForm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Facade;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;


class AppointmentFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Create a user for authentication
        $this->user = User::factory()->create();
        // Optionally, you can create any necessary related data (like positions, slots) here
    }

    /** @test *//** @test */

    public function it_can_create_an_appointment()
    {
        // Sample data for the appointment
        $data = [
            'position_id' => 1,
            'slot_id' => 1,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'contact' => '1234567890',
            'cover_letter' => 'Sample cover letter',
            'resume' => UploadedFile::fake()->create('resume.pdf', 100),
            'date' => now()->format('Y-m-d'),
        ];
    
        // Print the data for debugging
        Log::info('Appointment data:', $data); // Use capital "L" for Log
    
        // Authenticate the user
        $response = $this->actingAs($this->user)->postJson('/api/appointment/create', $data);
    
        // Assert the appointment was created
        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'Appointment scheduled successfully.',
                 ]);
    }

    /** @test */
    public function it_can_list_appointments()
    {
        // Create an appointment
        $appointment = AppointmentForm::factory()->create(['email' => 'john@example.com']);

        // Authenticate the user
        $response = $this->actingAs($this->user)->getJson('/api/manage-appointment/list');

        // Assert the appointment is in the response
        $response->assertStatus(200)
                 ->assertJsonFragment(['email' => 'john@example.com']);
    }

    /** @test */
    public function it_can_show_an_appointment()
    {
        // Create an appointment
        $appointment = AppointmentForm::factory()->create();

        // Authenticate the user
        $response = $this->actingAs($this->user)->getJson('/api/manage-appointment/show/' . $appointment->id);

        // Assert the appointment is shown
        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $appointment->id]);
    }

    /** @test */
    public function it_can_cancel_an_appointment()
    {
        // Create an appointment
        $appointment = AppointmentForm::factory()->create();

        // Authenticate the user
        $response = $this->actingAs($this->user)->getJson('/api/manage-appointment/interview-cancel/' . $appointment->id);

        // Assert the appointment status is 'canceled'
        $this->assertDatabaseHas('appointment_forms', [
            'id' => $appointment->id,
            'status' => 'canceled',
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Appointment cancelled successfully']);
    }

    /** @test */
    /** @test */
public function it_can_delete_an_appointment()
{
    // Create an appointment
    $appointment = AppointmentForm::factory()->create();

    // Authenticate the user
    $response = $this->actingAs($this->user)->deleteJson('/api/manage-appointment/delete/' . $appointment->id);

    // Assert the appointment is soft deleted
    $this->assertSoftDeleted('appointment_forms', [
        'id' => $appointment->id,
    ]);

    $response->assertStatus(200)
             ->assertJson(['message' => 'Appointment deleted Successfully']);
}

}
