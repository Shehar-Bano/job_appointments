<?php

namespace Tests\Feature;

use App\Models\AppointmentForm;
use App\Models\Position;
use App\Models\Slot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Facade;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;
use App\Mail\UserAppointmentConfirmation;
use App\Mail\AdminAppointmentNotification;
use App\Mail\AppointmentCancelled;



class AppointmentFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    
    protected $position;
    
    protected $slot;

    protected function setUp(): void
    {
        parent::setUp();
        // Create a user for authentication
        $this->user = User::factory()->create();
        // Optionally, you can create any necessary related data (like positions, slots) here
        $this->position = Position::factory()->create(); // Adjust as per your model name
        $this->slot = Slot::factory()->create();
    }

    /** @test *//** @test */

/** @test */
public function it_can_create_an_appointment()
{
    // Sample data for the appointment
    $data = [
        'position_id' => $this->position->id,
        'slot_id' => $this->slot->id,
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'contact' => '1234567890',
        'cover_letter' => 'Sample cover letter',
        'resume' => UploadedFile::fake()->create('resume.pdf', 100),
        'date' => now()->format('Y-m-d'),
    ];

    // Start listening for mail
    Mail::fake();

    $response = $this->actingAs($this->user)->postJson('/api/appointment/create', $data);
    
    // Assert the appointment was created
    $response->assertStatus(201)
             ->assertJson([
                 'message' => 'Appointment scheduled successfully', // Removed period here as well
                 'success' => true, // Ensure this is included
             ]);
}

    /** @test */
    public function it_can_list_appointments()
    {
        // Create an appointment
         AppointmentForm::factory()->create(['email' => 'john@example.com']);

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
   /** @test */
/** @test */
public function it_can_cancel_an_appointment()
{
    // Create an appointment
    $appointment = AppointmentForm::factory()->create(['status' => 'scheduled']); // Assuming a 'scheduled' status for initial state

    // Start listening for mail
    Mail::fake();

    // Authenticate the user
    $response = $this->actingAs($this->user)->getJson('/api/manage-appointment/interview-cancel/' . $appointment->id);

    // Assert the appointment status is 'canceled'
    $this->assertDatabaseHas('appointment_forms', [
        'id' => $appointment->id,
        'status' => 'canceled',
    ]);

    $response->assertStatus(200)
             ->assertJson(['message' => 'Appointment cancelled successfully']);

    // Assert that the cancellation email was sent to the user
    Mail::assertSent(AppointmentCancelled::class, function ($mail) use ($appointment) {
        return $mail->hasTo($appointment->email);
    });
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
/** @test */
public function it_checks_if_appointment_exists()
{
    // Create an appointment in the database
    $appointment = AppointmentForm::factory()->create([
        'slot_id' => $this->slot->id, // Use the created slot
        'date' => now()->format('Y-m-d'), // Use today's date for the appointment
    ]);

    // Sample data to check for existence
    $data = [
        'slot_id' => $appointment->slot_id, // Same slot_id as the created appointment
        'date' => $appointment->date, // Same date as the created appointment
    ];

    // Call the existingAppointment method
    $response = $this->postJson('/api/appointment/check-existence', $data);

    // Assert that the appointment exists
    $response->assertStatus(409) // 409 Conflict
             ->assertJson([
                 'message' => 'Appointment already scheduled',
             ]);
}

/** @test */
public function it_checks_if_appointment_does_not_exist()
{
    // Sample data to check for existence
    $data = [
        'slot_id' => 1, // Assuming this slot_id doesn't exist in the database
        'date' => now()->format('Y-m-d'), // Today's date
    ];

    // Call the existingAppointment method
    $response = $this->postJson('/api/appointment/check-existence', $data);

    // Assert that the appointment does not exist
    $response->assertStatus(404) // 404 Not Found
             ->assertJson([
                 'message' => 'Appointment does not exist',
             ]);
}
/** @test */

}
