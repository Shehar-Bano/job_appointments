<?php

namespace App\Actions;

use App\Mail\AppointmentCancelled;
use App\Models\AppointmentForm;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ManageAppointmentsAction
{
    public function getAppointments(int $position_id, int $limit, ?string $start_date, ?string $end_date, ?string $email, ?string $name): LengthAwarePaginator|false
    {
        $appointments = AppointmentForm::query()
            ->whereEmail($email)
            ->whereName($name)
            ->whereDate('date_column', '>=', $start_date) // Adjust to your actual date field
            ->whereDate('date_column', '<=', $end_date)
            ->wherePosition($position_id)
            ->with(['position', 'slot'])
            ->paginate($limit);

        return $appointments->isEmpty() ? false : $appointments;
    }

    public function showAppointment(int $appointment_id): AppointmentForm|false
    {
        $appointment = AppointmentForm::with(['position', 'slot'])->find($appointment_id);
        return $appointment ?: false;
    }

    public function destroy(int $appointment_id): AppointmentForm|false
    {
        $appointment = AppointmentForm::find($appointment_id);
        if (! $appointment) {
            return false;
        }
        $appointment->delete();

        return $appointment;
    }

<<<<<<< HEAD
    public function interviewDone(int $id): AppointmentForm|false
=======
    public function interviewDone($id)
>>>>>>> 50a1595f49378627141955d26ed39dbdb0ce8243
    {
        $appointment = AppointmentForm::find($id);
        if (! $appointment) {
            return false;
        }
        $appointment->status = 'done';
        $appointment->save();

        return $appointment;
    }

<<<<<<< HEAD
    public function cancel(int $id): AppointmentForm|false
    {
        $appointment = AppointmentForm::find($id);
        if (!$appointment) {
            return false;
        }

=======
    public function cancel($id)
    {
        $appointment = AppointmentForm::find($id);

        if (! $appointment) {
            return false;
        }

>>>>>>> 50a1595f49378627141955d26ed39dbdb0ce8243
        $appointment->status = 'canceled';
        $appointment->save();

        Mail::to($appointment->email)->send(new AppointmentCancelled($appointment));

        return $appointment;
    }
}
