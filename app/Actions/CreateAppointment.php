<?php
namespace App\Actions;

use App\Models\Slot;
use App\Models\AppointmentForm;
use Illuminate\Http\UploadedFile;
use App\Mail\UserAppointmentConfirmation;
use Illuminate\Support\Facades\Validator;
use App\Mail\AdminAppointmentNotification;
use Illuminate\Support\Facades\Mail;

class CreateAppointment
{
    public function checkAppointment($request)
    {
        $date = $request->input('date');
        $slotId = $request->input('slot_id');


        $existingAppointment = AppointmentForm::where('slot_id', $slotId)
            ->where('date', $date)
            ->first();


        return $existingAppointment ? true : false;
    }


    public function execute($request)
    {
        $validated = $request->validate([
            'position_id' => 'required|exists:positions,id',
            'slot_id' => 'required|exists:slots,id',
            'name' => 'required|string|max:50',
            'email' => 'required|email',
            'contact' => 'required|string',
            'cover_letter' => 'nullable|string',
            'resume' => 'required|file|mimes:pdf,doc,docx',
            'date' => 'required|date',
        ]);

        if (isset($validated['resume']) && $validated['resume'] instanceof UploadedFile) {
            $filePath = $validated['resume']->store('resumes', 'public');
            $validated['resume'] = $filePath;
        }

        $appointment = AppointmentForm::create($validated);

        // Send email to user
        Mail::to($validated['email'])->queue(new UserAppointmentConfirmation($appointment));

        // Send email to admin through queue
        Mail::to('rhondajarvis274@gmail.com')->queue(new AdminAppointmentNotification($appointment));

        return response()->json([
            'message' => 'Appointment scheduled successfully.',
            'appointment' => $appointment,
            'success' => true,
        ], 201);
    }

}
