<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentForm extends Model
{
    use HasFactory;
    protected $fillable = ['job_id','slot_id','name','email','contact','description','resume','slot','status'];
}
