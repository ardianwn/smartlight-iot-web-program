<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'start_time',
        'end_time',
        'days_of_week',
        'action',
        'is_active',
        'name',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the days of week as an array
     * 
     * @return array
     */
    public function getDaysOfWeekArrayAttribute(): array
    {
        return json_decode($this->days_of_week, true) ?? [];
    }

    /**
     * Set the days of week from an array
     * 
     * @param array $value
     * @return void
     */
    public function setDaysOfWeekArrayAttribute(array $value): void
    {
        $this->attributes['days_of_week'] = json_encode($value);
    }

    /**
     * Check if the schedule is active for the current day
     * 
     * @return bool
     */
    public function isActiveToday(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $today = date('w'); // 0 (Sunday) to 6 (Saturday)
        $days = $this->days_of_week_array;

        return in_array($today, $days);
    }

    /**
     * Check if the schedule is active for the current time
     * 
     * @return bool
     */
    public function isActiveNow(): bool
    {
        if (!$this->isActiveToday()) {
            return false;
        }

        $now = date('H:i:s');
        return $now >= $this->start_time && $now <= $this->end_time;
    }

    /**
     * Get the action to take (true for on, false for off)
     * 
     * @return bool
     */
    public function getActionValueAttribute(): bool
    {
        return $this->action === 'on';
    }
}
