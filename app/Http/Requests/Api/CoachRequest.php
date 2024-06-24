<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CoachRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'start_date' => ['nullable', 'required_with:end_date', 'date', 'before:end_date'],
            'end_date' => ['nullable', 'required_with:start_date', 'date', 'after:start_date'],
        ];
    }

    /**
     * If the request is empty, set the default start and end date to the current week.
     */
    protected function passedValidation(): void
    {
        if (blank($this->all())) {
            $this->replace([
                'start_date' => now()->startOfWeek(),
                'end_date' => now()->endOfWeek(),
            ]);
        }
    }

    public function authorize(): bool
    {
        return true;
    }
}
