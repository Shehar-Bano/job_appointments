<?php

namespace App\Http\Controllers;

use App\Actions\ManageAppointmentsAction;
use App\Helpers\ResponseHelper;
use App\Http\Resources\AppointmentResource;
use Illuminate\Http\Request;


/**
 * @OA\Tag(
 *     name="Manage Appointment",
 *     description="API Endpoints for admin to managing appointments"
 * )
 */

class ManageAppointmentController extends Controller
{
    protected $appointments;

    public function __construct(ManageAppointmentsAction $appointments)
    {
        $this->appointments = $appointments;

    }
      /**
     * @OA\Get(
     *     path="/api/manage-appointment/list",
     * security={{"bearerAuth": {}}},
     *     tags={"Manage Appointment"},
     *     summary="Get a list of appointments",
     *     @OA\Parameter(name="limit", in="query", required=false, @OA\Schema(type="integer", example=10)),
     *     @OA\Parameter(name="start_date", in="query", required=false, @OA\Schema(type="string", format="date", example="2024-10-01")),
     *     @OA\Parameter(name="end_date", in="query", required=false, @OA\Schema(type="string", format="date", example="2024-10-31")),
     *     @OA\Parameter(name="email", in="query", required=false, @OA\Schema(type="string", format="email", example="john@example.com")),
     *     @OA\Parameter(name="name", in="query", required=false, @OA\Schema(type="string", example="John Doe")),
     *     @OA\Parameter(name="position_id", in="query", required=false, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="List of appointments retrieved successfully"),
     *     @OA\Response(response=404, description="No appointments found"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */

    public function index(Request $request)
    {
        try {

            $limit = $this->getValue($request->input('limit'));
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $email = $request->input('email');
            $name = $request->input('name');
            $position_id = $request->input('position_id');

            $appointments = $this->appointments->getAppointments(
                $position_id,
                $limit,
                $start_date,
                $end_date,
                $email,
                $name,

            );

            if (! $appointments) {
                return ResponseHelper::error('No appointments found', 404);

            }
            $data = AppointmentResource::collection($appointments);
            $paginatedData = [

                'data' => $data,
                'Pagination_Limit' => $data->count(),

                'Current_Page' => $data->currentPage(),

                'Total_Recode' => $data->total(),
            ];

            return ResponseHelper::success($paginatedData, 200);

        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), 500);
        }
    }
     /**
     * @OA\Get(
     *     path="/api/manage-appointment/show/{id}",
     * security={{"bearerAuth": {}}},
     *     tags={"Manage Appointment"},
     *     summary="Show appointment details",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Appointment details retrieved successfully"),
     *     @OA\Response(response=404, description="Appointment not found"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */

    public function show($id)
    {
        try {
            $appointment = $this->appointments->showAppointment($id);
            if (! $appointment) {
                return ResponseHelper::error('Appointment not found', 404);
            }
            $data = new AppointmentResource($appointment);

            return ResponseHelper::success($data, 200);

        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), 500);
        }
    }
/**
     * @OA\Delete(
     *     path="/api/manage-appointment/delete/{id}",
     * security={{"bearerAuth": {}}},
     *     tags={"Manage Appointment"},
     *     summary="Delete an appointment",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Appointment deleted successfully"),
     *     @OA\Response(response=404, description="Appointment not found"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */

    public function destroy($id)
    {
        try {
            $appointment = $this->appointments->destroy($id);
            if (! $appointment) {
                return ResponseHelper::error('Appointment not found', 404);
            }

            return ResponseHelper::successMessage('Appointment deleted Successfully', 200);

        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), 500);
        }
    }
 /**
     * @OA\Get(
     *     path="/api/manage-appointment/interview-done/{id}",
     * security={{"bearerAuth": {}}},
     *     tags={"Manage Appointment"},
     *     summary="Mark an interview as done",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Interview marked as done successfully"),
     *     @OA\Response(response=404, description="Appointment not found"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function interviewDone($id)
    {
        try {
            $appointment = $this->appointments->interviewDone($id);
            if (! $appointment) {
                return ResponseHelper::error('Appointment not found', 404);
            }

            return ResponseHelper::successMessage('appointment  done successfully');
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), 500);
        }
    }
        /**
     * @OA\Get(
     *     path="/api/manage-appointment/interview-cancel/{id}",
     * security={{"bearerAuth": {}}},
     *     tags={"Manage Appointment"},
     *     summary="Cancel an interview",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer", example=1)),
     *     @OA\Response(response=200, description="Interview canceled successfully"),
     *     @OA\Response(response=404, description="Appointment not found"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */

    public function interviewCancel($id)
    {
        try {

            $appointment = $this->appointments->cancel($id);
            if (! $appointment) {
                return ResponseHelper::error('Appointment not found', 404);
            }

            return ResponseHelper::successMessage('Appointment cancelled successfully', 200);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), 404);
        }

    }
}
