<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentForm extends Model
{
    use HasFactory;
    protected $fillable = ['position_id','slot_id','name','email','contact','cover_letter','resume','slot','date'];
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function slot()
{
    return $this->belongsTo(Slot::class);
}

public function scopeWhereEmail($query, $email){
    if($email){
        $query->where('email','like','%'.$email.'%');
    }
    return $query;
}
public function scopeWhereDate($query, $start_date = null, $end_date = null)
{
    if (!empty($start_date) || !empty($end_date)) {
        // Use whereBetween for date filtering
        return $query->whereBetween('date', [$start_date, $end_date]);
    }

    

    return $query;
}

    public function scopeWhereName($query, $name){
        if($name){
            $query->where('name','like','%'.$name.'%');
            $query->orWhere('name','like','%'.$name.'%');
            }
            return $query;
    }
    public function scopeWherePosition($query,$positionId){
        if($positionId){
            $query->where('position_id', $positionId);
        }
        return $query;
    }
}

