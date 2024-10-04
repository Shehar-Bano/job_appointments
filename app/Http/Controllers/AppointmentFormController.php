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
    public function existingAppointment(Request $request)
{
    $appointmentExists = $this->appointments->checkAppointment($request);

    if ($appointmentExists) {

        return response()->json(['message' => 'Appointment already scheduled'], 409);
    }

    return response()->json(['message' => 'Appointment does not exist'], 404);
}

    public function store(Request $request)
    {
        try {
          $appointment= $this->appointments->execute($request);
          if($appointment){
            return response()->json(['message' => 'Appointment scheduled successfully'], 200);
          }
            return response()->json([ 'message' => 'Appointment already scheduled']);

        } catch (\Exception $e) {
            // Return a JSON response with the error message
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
