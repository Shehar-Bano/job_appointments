<?php
namespace App\Mail;

use App\Models\AppointmentForm;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentCancelled extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;

    public function __construct(AppointmentForm $appointment)
    {
        $this->appointment = $appointment;
    }

    public function build()
    {
        return $this->view('emails.appointment_cancelled')
                    ->with([
                        'candidateName' => $this->appointment->name,
                        'appointmentDate' => $this->appointment->date,
                        'slotStartTime' => $this->appointment->slot->start_time, // Add slot start time
                        'slotEndTime' => $this->appointment->slot->end_time,     // Add slot end time
                        // You can add more slot details as needed
                    ])
                    ->subject('Your Appointment Has Been Canceled');
    }
}
