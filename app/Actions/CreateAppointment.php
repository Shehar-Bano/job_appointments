<?php

namespace App\Actions;

use App\Models\Slot;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Models\AppointmentForm;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Mail\UserAppointmentConfirmation;
use App\Mail\AdminAppointmentNotification;

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,jfif|max:2048',
            'name' => 'required|string|max:50',
            'email' => 'required|email',
            'contact' => 'required|string',
            'cover_letter' => 'nullable|string',
            'resume' => 'required|file|mimes:pdf,doc,docx',
            'date' => 'required|date',
            'mode'=>'required',
        ]);
   
        // Handle image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $imageName = time() . "-" . $fileName;
    
            // Move the uploaded file to the public resources/images directory
            $file->move(public_path('resources/images/'), $imageName);
    
            // Append the image path to the validated data
            $validated['image'] = env('APP_URL') . '/resources/images/' . $imageName;
        }
    
        // Handle resume upload
        if (isset($validated['resume']) && $validated['resume'] instanceof UploadedFile) {
            $filePath = $validated['resume']->store('resumes', 'public');
            $validated['resume'] = $filePath;
        }
        // dd($validated);
        // Create an appointment record
        $appointment = AppointmentForm::create($validated);
    
        // Send email notifications
        Mail::to($validated['email'])->send(new UserAppointmentConfirmation($appointment));
        Mail::to('careers@thesparksolutionz.com')->send(new AdminAppointmentNotification($appointment));
    
        return $appointment;
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
