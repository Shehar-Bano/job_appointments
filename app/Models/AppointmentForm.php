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
public function scopeWhereDate($query, $startDate = null, $endDate = null)
{
    if (!empty($startDate) && !empty($endDate)) {
        return $query->whereBetween('date', [$startDate, $endDate]);
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
}

