<?php

namespace App\Rules;

use App\Models\Coach;
use App\Models\Schedule;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CoachAvailableRule implements DataAwareRule, ValidationRule
{
    /**
     * @var array{date: string, start_time: string, end_time: string}
     */
    protected array $data;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $coach = Coach::query()
            ->whereId($value)
            ->with([
                'schedules' => function (Builder|HasMany $query) {
                    /** @var Schedule $query */
                    $query->getScheduleFromDate($this->data['date'])
                        ->where('start_time', '<=', $this->data['start_time'])
                        ->where('end_time', '>=', $this->data['end_time']);
                },
                'appointments' => function (Builder|HasMany $query) {
                    $query->where('date', $this->data['date'])
                        ->where(function (Builder|HasMany $query) {
                            $query->whereBetween('start_time', [$this->data['start_time'], $this->data['end_time']])
                                ->orWhereBetween('end_time', [$this->data['start_time'], $this->data['end_time']]);
                        });
                },
            ])
            ->first();

        // The "exists" rule handles the case where the coach does not exist.
        if (is_null($coach)) {
            return;
        }

        if ($coach->schedules->isEmpty()) {
            $fail('The coach is not available on the given date or time.');

            return;
        }

        if ($coach->appointments->isNotEmpty()) {
            $fail('The coach is not available at the given time.');
        }
    }

    /**
     * @param  array<string, string>  $data
     * @return $this
     */
    public function setData(array $data): static
    {
        $this->data = [
            'date' => $data['date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
        ];

        return $this;
    }
}
