<?php
namespace App\Actions;
use App\Models\AppointmentForm;

class ManageAppointmentsAction
{
    public function getAppointments($limit, $start_date, $end_date,  $email, $name, $position_id){
        $appointments= AppointmentForm::whereEmail($email)->whereName( $name)->
        whereDate($start_date, $end_date)->wherePosition($position_id)->
        with(['position','slot'])->paginate($limit);
        if(! $appointments){
          return false;
        }
        return $appointments;
  
      }
}
