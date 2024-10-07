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
      
            $limit=$this->getValue($request->input('limit'));
            return $this->appointments->getAppointments($limit);
        

       
    }
        
    }

