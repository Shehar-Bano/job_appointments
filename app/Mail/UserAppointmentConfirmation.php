<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserAppointmentConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
             ->subject('Appointment Confirmation')
            ->view('emails.user_confirmation')
            ->with(['appointment' => $this->appointment]);
    }
}
