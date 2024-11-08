<?php
namespace App\Http\Controllers;

use App\Actions\CreateAppointment;
use App\Http\Resources\SlotResource;
use Illuminate\Http\Request;

/**
  * @OA\Schema(
 *     schema="AppointmentRequest",
 *     type="object",
 *     title="Appointment Request",
 *     description="Schema for creating or updating an appointment",
 *     required={"position_id", "slot_id", "name", "email", "contact", "cover_letter", "resume", "date"},
 *     @OA\Property(property="position_id", type="integer", example=1, description="ID of the job position for the appointment"),
 *     @OA\Property(property="slot_id", type="integer", example=2, description="ID of the time slot for the appointment"),
 *     @OA\Property(property="name", type="string", example="John Doe", description="Name of the applicant"),
 *     @OA\Property(property="email", type="string", format="email", example="john.doe@example.com", description="Email address of the applicant"),
 *     @OA\Property(property="contact", type="string", example="+1234567890", description="Contact number of the applicant"),
 *     @OA\Property(property="cover_letter", type="string", example="I am excited to apply for this position...", description="Cover letter provided by the applicant"),
 *     @OA\Property(property="resume", type="string", format="binary", description="Resume file of the applicant"),
 *     @OA\Property(property="date", type="string", format="date", example="2024-11-20", description="Date of the appointment"),
 *     @OA\Property(property="status", type="string", example="scheduled", enum={"scheduled", "done", "canceled"}, description="Status of the appointment")
 * )
 * @OA\Schema(
 *     schema="AppointmentForm",
 *     type="object",
 *     @OA\Property(property="position_id", type="integer", example=1),
 *     @OA\Property(property="slot_id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="contact", type="string", example="123-456-7890"),
 *     @OA\Property(property="cover_letter", type="string", example="I am applying for..."),
 *     @OA\Property(property="resume", type="string", format="binary"),
 *     @OA\Property(property="date", type="string", format="date", example="2024-10-15"),
 *     @OA\Property(property="status", type="string", enum={"scheduled", "done", "canceled"}, example="scheduled"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-10T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-10T12:00:00Z"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", example="2024-10-10T12:00:00Z"),
 * )
 */
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
            $appointment = $this->appointments->execute($request);
            if ($appointment) {
                return response()->json(['message' => 'Appointment scheduled successfully', 'success' => true], 200);
            }
            return response()->json(['message' => 'Appointment already scheduled'], 409);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/appointment/check-existence",
     *     tags={"Appointment"},
     *     summary="Check if an appointment already exists",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"date", "slot_id"},
     *             @OA\Property(property="date", type="string", format="date", example="2024-10-15"),
     *             @OA\Property(property="slot_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Appointment does not exist"),
     *     @OA\Response(response=404, description="Appointment already scheduled"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function existingAppointment(Request $request)
    {
        $appointmentExists = $this->appointments->checkAppointment($request);

        if ($appointmentExists) {
            return response()->json(['message' => 'Appointment already scheduled'], 409);
        }

        return response()->json(['message' => 'Appointment does not exist'], 404);
    }
    public function listSlots(){
       try{
        $slots = $this->appointments->listSlots();
        if($slots ){
            return response()->json(['success'=>true,'data'=>SlotResource::collection($slots)],200);
        }
        return response()->json(['success'=>false,'message'=>'No slots available'],404);


       }
       catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function PositionDetail($id){
        try{
            $position = $this->appointments->getPositionDetail($id);
            if($position){
                return response()->json(['success'=>true,'data'=>$position],200);
                }
                return response()->json(['success'=>false,'message'=>'Position not found'],404);
                }
                catch (\Exception $e) {
                    return response()->json(['error' => $e->getMessage()], 500);
                }

    }
}
