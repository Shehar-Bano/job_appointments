<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 *
 * @property int $id
 * @property int $position_id
 * @property int $slot_id
 * @property string $name
 * @property string $email
 * @property string $contact
 * @property string $cover_letter
 * @property string $resume
 * @property string $date
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Position $position
 * @property-read \App\Models\Slot $slot
 * @method static \Database\Factories\AppointmentFormFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentForm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentForm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentForm onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentForm query()
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentForm whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentForm whereCoverLetter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentForm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentForm whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentForm whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentForm whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentForm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentForm whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentForm wherePosition($position_id = null)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentForm wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentForm whereResume($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentForm whereSlotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentForm whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentForm whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentForm withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentForm withoutTrashed()
 * @mixin \Eloquent
 */
class AppointmentForm extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['position_id', 'slot_id', 'name', 'email', 'contact', 'cover_letter', 'resume', 'date'];
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }

    // Add any necessary scopes if needed
    public function scopeWhereName($query, ?string $name)
    {
        if ($name) {
            return $query->where('name', 'like', '%' . $name . '%');
        }
        return $query;
    }

    public function scopeWherePosition($query, int $position_id)
    {
        return $query->where('position_id', $position_id);
    }
public function scopeWhereEmail($query, $email){
    if($email){
        $query->where('email','like','%'.$email.'%');
    }
    return $query;
}
public function scopeWhereDate($query, $start_date = null, $end_date = null)
{
    if (!empty($start_date) && !empty($end_date)) {
        // Use whereBetween for date filtering
        return $query->whereBetween('date', [$start_date, $end_date]);
    }

    // Optionally, if you want to handle cases where only one date is provided
    if (!empty($start_date) || !empty($end_date)) {
        return $query->where('date', '>=', $start_date)->orWhere('date', '<=', $end_date);
    }



    return $query;
}



}

