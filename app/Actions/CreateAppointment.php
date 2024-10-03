<?php
namespace App\Actions;

use App\Models\AppointmentForm;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;

class CreateAppointment
{
    public function execute($validated)
    {
       

       

        // Handle the file upload
        if (isset($validated['resume']) && $validated['resume'] instanceof UploadedFile) {
            $filePath = $validated['resume']->store('resumes', 'public'); // Save the file
            
            $validated['resume'] = $filePath; // Update the file path in validated data
        }

        // Create the appointment form with the validated data
        return AppointmentForm::create($validated);
    }
}
