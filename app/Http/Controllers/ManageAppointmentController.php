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
            $start_date=$request->input('start_date');
            $end_date=$request->input('end_date');
            $email=$request->input('email');
            $name=$request->input('name');
            $position_id=$request->input(' position_id');

            $appointments = $this->appointments->getAppointments($limit, $start_date, $end_date,  $email,
             $name, $position_id);

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

