<?php

namespace App\Http\Controllers;

use App\Actions\ManageAppointmentsAction;
use App\Helpers\ResponseHelper;
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
            return ResponseHelper::success($appointments, 200);

        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), 500);
        }
    }
        
    }

