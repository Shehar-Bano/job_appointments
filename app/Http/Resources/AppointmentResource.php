<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'contact' => $this->contact,
            'cover_letter' => $this->cover_letter,
            'status' => $this->status,
            'image' => $this->image,
            'mode'=>$this->mode,
            'resume' => $this->resume,
            'date' => $this->date,
            'slot_id' => $this->slot_id,
            'start_time' => $this->slot->start_time,
            'end_time' => $this->slot->end_time,
            'position_id' => $this->position_id,
            'title' => $this->position->title,
            'job_type' => $this->position->job_type,
            'position_status' => $this->position->status,
            'description' => $this->position->description,
            'post_date' => $this->position->post_date,

        ];
    }
}
