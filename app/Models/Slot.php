<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slot extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable=[
        "start_time","end_time","status"
    ];
    public function appointmentForms()
    {
        return $this->hasMany(AppointmentForm::class);
    }

    public function scopeWhereStatus($query, $status){
        if($status){
            return $query->where('status', $status);
           
        }
        return $query;
    }
    
    public function scopeWhereTime($query,$start_time,  $end_time){
        if($start_time && $end_time){
            return $query->whereBetween('start_time',[$start_time,$end_time]);
            } elseif ($start_time) {
                
                $query->where('start_time', '>=', $start_time);
            } elseif ($end_time) {

                $query->where('end_time', '<=', $end_time);
            }
            return $query;
    }

}
