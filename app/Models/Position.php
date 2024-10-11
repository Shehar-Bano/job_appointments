<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property string $job_type
 * @property string $requirement
 * @property string $status
 * @property string $description
 * @property string $post_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AppointmentForm> $appointmentForms
 * @property-read int|null $appointment_forms_count
 * @method static \Database\Factories\PositionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Position newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Position newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Position query()
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereJobType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position wherePostDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereRequirement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Position extends Model
{
    use HasFactory;
    protected $fillable = ['title','job_type','requirement','skills','status','description','post_date'];
    public function appointmentForms()
    {
        return $this->hasMany(AppointmentForm::class);
    }
}
