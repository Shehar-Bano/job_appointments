<?php

namespace App\Http\Controllers;

use App\Actions\ManageAppointmentsAction;
use App\Helpers\ResponseHelper;
use App\Http\Resources\AppointmentResource;
use Illuminate\Http\Request;

class ManageAppointmentController extends Controller
{
    protected $appointments;
    public function __construct(ManageAppointmentsAction $appointments){
        $this->appointments = $appointments;

    }
    public function index(Request $request){
        try {
            $limit=$this->getValue($request->input('limit'));
            $appointments = $this->appointments->getAppointments($limit);

            if (!$appointments) {
                return ResponseHelper::error('No appointments found', 404);

            }
            $data=AppointmentResource::collection($appointments);
            $paginatedData=[
                'data'=>$data,
                'Pagination_Limit'=>$data->count(),
            
                'Current_Page'=> $data->currentPage(),
    
                'Total_Recode'=> $data->total(),
            ];

            return ResponseHelper::success($paginatedData, 200);

        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), 500);
        }
    }
        
    }

