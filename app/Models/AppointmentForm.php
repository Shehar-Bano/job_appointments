<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

        /**
         * @property int $id
         * @property string $email
         * @property int $slot_id
         * @property string $date
         */
        
class AppointmentForm extends Model
{
    use HasFactory, SoftDeletes;
  
   

    protected $fillable = ['id', 'position_id', 'slot_id', 'name', 'email', 'contact', 'cover_letter', 'resume', 'slot', 'date', 'status'];
 // Accessors for protected properties
 public function getEmailAttribute()
 {
     return $this->attributes['email'];
 }

 public function getSlotIdAttribute()
 {
     return $this->attributes['slot_id'];
 }

 public function getDateAttribute()
 {
     return $this->attributes['date'];
 }
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }

    public function scopeWhereEmail($query, $email)
    {
        if ($email) {
            $query->where('email', 'like', '%'.$email.'%');
        }

        return $query;
    }

    public function scopeWhereDate($query, $start_date = null, $end_date = null)
    {
        if (! empty($start_date) && ! empty($end_date)) {
            // Use whereBetween for date filtering
            return $query->whereBetween('date', [$start_date, $end_date]);
        }

        // Optionally, if you want to handle cases where only one date is provided
        if (! empty($start_date) || ! empty($end_date)) {
            return $query->where('date', '>=', $start_date)->orWhere('date', '<=', $end_date);
        }

        return $query;
    }

    public function scopeWhereName($query, $name)
    {
        if ($name) {
            $query->where('name', 'like', '%'.$name.'%');
            $query->orWhere('name', 'like', '%'.$name.'%');
        }

        return $query;
    }

    public function scopeWherePosition($query, $position_id = null)
    {
        if ($position_id) {
            return $query->where('position_id', $position_id);
        }

        return $query;
    }
}
