<?php
namespace App\Actions;

use App\Mail\AppointmentCancelled;
use App\Models\AppointmentForm;
use Illuminate\Support\Facades\Mail;

class ManageAppointmentsAction
{
    public function getAppointments($limit, $start_date, $end_date, $email, $name, $position_id)
    {
        $appointments = AppointmentForm::whereEmail($email)->whereName($name)->
            whereDate($start_date, $end_date)->wherePosition($position_id)->
            with(['position', 'slot'])->paginate($limit);
        if (!$appointments) {
            return false;
        }
        return $appointments;

    }
    public function showAppointment($appointment_id)
    {
        $appointment = AppointmentForm::with(['position', 'slot'])->find($appointment_id);
        if (!$appointment) {
            return false;
        }
        return $appointment;
    }

    public function destroy($appointment_id)
    {
        $appointment = AppointmentForm::find($appointment_id);
        if (!$appointment) {
            return false;
        }
        $appointment->delete();
        return $appointment;
    }
    public function interviewDone($id)
    {
        $appointment = AppointmentForm::find($id);
        if (!$appointment) {
            return false;
        }
        $appointment->status = 'done';
        $appointment->save();
        return $appointment;
    }
    public function cancel($id)
    {
        $appointment = AppointmentForm::find($id);

        if (!$appointment) {
            return false;
        }
        if($appointment->status == 'canceled'){
            return false;
        }
        $appointment->status = 'canceled';
        $appointment->save();
        Mail::to($appointment->email)->send(new AppointmentCancelled($appointment));

        return $appointment;


    }
}
