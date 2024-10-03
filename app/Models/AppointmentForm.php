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
}

