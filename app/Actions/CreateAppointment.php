<?php

namespace App\Actions;

use App\Mail\AdminAppointmentNotification;
use App\Mail\UserAppointmentConfirmation;
use App\Models\AppointmentForm;
use App\Models\Position;
use App\Models\Slot;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CreateAppointment
{
    /**
     * Check if an appointment already exists for the given slot and date.
     *
     * @param Request $request
     * @return bool
     */
    public function checkAppointment(Request $request): bool
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

        // Handle resume upload
        if (isset($validated['resume']) && $validated['resume'] instanceof UploadedFile) {
            $filePath = $validated['resume']->store('resumes', 'public');
            $validated['resume'] = $filePath;
        }

        // Create the appointment
        $appointment = AppointmentForm::create($validated);

        // Send email to user
        Mail::to($validated['email'])->queue(new UserAppointmentConfirmation($appointment));

        // Send email to admin
        Mail::to('rhondajarvis274@gmail.com')->queue(new AdminAppointmentNotification($appointment));

        return response()->json([
            'message' => 'Appointment scheduled successfully.',
            'appointment' => $appointment,
            'success' => true,
        ], 201);
    }
    public function listSlots(){
        $cacheKey="slots";
        $slots = Cache::remember($cacheKey, 60, function () {
            return Slot::get();
            });
       
        if($slots){
            return  $slots;
        }
        return false;

    }
    public function getPositionDetail($id){
        $cacheKey="position_{$id}";
        $position = Cache::remember($cacheKey, 60, function () use ($id)
        {
            return Position::findOrFail($id);
            });
            if($position){
                return $position;
                }
                return false;
            

    }
}
