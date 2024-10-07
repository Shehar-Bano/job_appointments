<?php
namespace App\Actions;
use App\Models\AppointmentForm;

class ManageAppointmentsAction
{
    public function getAppointments($limit){
        $appointments= AppointmentForm::with(['position','slots'])->paginate($limit);
        if(! $appointments){
          return false;
        }
        return $appointments;
  
      }
}
