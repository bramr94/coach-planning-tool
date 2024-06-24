<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Schedule extends Model
{
    protected $fillable = [
        'coach_id',
        'day',
        'start_time',
        'end_time',
        'is_available',
    ];

    protected $casts = [
        'day' => 'integer',
        'is_available' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Coach, self>
     */
    public function coach(): BelongsTo
    {
        return $this->belongsTo(Coach::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Appointment>
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /*
     * Get the full day name.
     *
     * @return ?string
     */
    public function getDayNameAttribute(): ?string
    {
        return Carbon::getDays()[$this->day] ?? null;
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder<self>  $query
     */
    public static function scopeGetScheduleFromDate(Builder $query, Carbon|string $date, bool $available = true): void
    {
        if (! $date instanceof Carbon) {
            $date = Carbon::parse($date);
        }

        $query->where('day', $date->dayOfWeek())
            ->where('is_available', $available);
    }
}
