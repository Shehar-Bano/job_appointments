<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserAppointmentConfirmation extends Mailable
{
    use  SerializesModels;

    public $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

   public function build()
{
    return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
        ->subject('Appointment Confirmation')
        ->view('emails.user_confirmation')
        ->with(['appointment' => $this->appointment]);
}
}
