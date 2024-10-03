<?php

namespace App\Http\Controllers;

use App\Actions\ManageAppointmentsAction;
use Illuminate\Http\Request;

class ManageAppointmentController extends Controller
{
    protected $appointments;
    public function __construct(ManageAppointmentsAction $appointments){
        $this->appointments = $appointments;

    }
    public function index(){
        return $this->appointments->getAppointments();
        
    }
}
