<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 /**
         * @property int $id
         */
class Position extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'job_type', 'requirement', 'skills', 'status', 'description', 'post_date'];

    public function appointmentForms()
    {
        return $this->hasMany(AppointmentForm::class);
    }
}
