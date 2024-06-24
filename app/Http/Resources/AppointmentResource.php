<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * @var \App\Models\Appointment
     */
    public $resource;

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'date' => $this->resource->date,
            'user' => UserResource::make($this->whenLoaded('user')),
            'coach' => CoachResource::make($this->whenLoaded('coach')),
            'start_time' => $this->resource->start_time,
            'end_time' => $this->resource->end_time,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
