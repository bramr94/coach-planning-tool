<?php

namespace App\Http\Requests\Api;

use App\Rules\CoachAvailableRule;
use Illuminate\Foundation\Http\FormRequest;

class AppointmentStoreRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'coach_id' => ['required', 'integer', 'exists:coaches,id', new CoachAvailableRule()],
            'date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i:s', 'before:end_time'],
            'end_time' => ['required', 'date_format:H:i:s', 'after:start_time'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
