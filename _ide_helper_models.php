<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
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
 */
	class AppointmentForm extends \Eloquent {}
}

namespace App\Models{
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
 */
	class Position extends \Eloquent {}
}

namespace App\Models{
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
 */
	class Slot extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $email
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Tymon\JWTAuth\Contracts\JWTSubject {}
}

