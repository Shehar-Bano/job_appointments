<?php
namespace App\Actions;

use App\Helpers\ResponseHelper;
use App\Models\AppointmentForm;

class ManageAppointmentsAction
{
    public function getAppointments($limit){
       try{
        $appointments= AppointmentForm::paginate($limit);
        if (!$appointments) {
            return ResponseHelper::error('No appointments found', 404);

        }
      }
      catch(\Exception $e){
        return ResponseHelper::error($e->getMessage(), 500);
        }
}
       }
