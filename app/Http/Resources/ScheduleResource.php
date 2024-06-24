<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * @var \App\Models\Schedule
     */
    public $resource;

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'coach_id' => $this->resource->coach_id,
            'day' => $this->resource->day,
            'day_name' => $this->resource->day_name,
            'start_time' => $this->resource->start_time,
            'end_time' => $this->resource->end_time,
            'is_available' => $this->resource->is_available,
            'appointments' => AppointmentResource::collection($this->whenLoaded('appointments')),
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
