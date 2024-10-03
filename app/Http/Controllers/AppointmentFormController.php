<?php
namespace App\Http\Controllers;

use App\Actions\CreateAppointment;
use Illuminate\Http\Request;

class AppointmentFormController extends Controller
{
    protected $appointments;

    public function __construct(CreateAppointment $createAppointment)
    {
        $this->appointments = $createAppointment;
    }

    public function store(Request $request)
    {
        try {

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

           
           $this->appointments->execute($validated);
            return response()->json([ 'message' => 'Appointment scheduled successfully'], 200);

        } catch (\Exception $e) {
            // Return a JSON response with the error message
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
