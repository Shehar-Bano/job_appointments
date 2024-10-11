<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property int $id
 * @property string $start_time
 * @property string $end_time
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AppointmentForm> $appointmentForm
 * @property-read int|null $appointment_form_count
 * @method static \Database\Factories\SlotFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Slot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slot onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Slot query()
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereStatus($status)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereTime($start_time, $end_time)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slot withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Slot withoutTrashed()
 * @mixin \Eloquent
 */
class Slot extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable=[
        "start_time","end_time","status"
    ];
    

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

    
    public function appointmentForm()
    {
        return $this->hasMany(AppointmentForm::class);
    }

}
