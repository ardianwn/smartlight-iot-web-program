<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schedules = [
            [
                'name' => 'Morning Routine',
                'start_time' => '06:00:00',
                'end_time' => '08:00:00',
                'days_of_week' => json_encode([1, 2, 3, 4, 5]), // Monday to Friday
                'action' => 'on',
                'is_active' => true,
            ],
            [
                'name' => 'Evening Lights',
                'start_time' => '18:00:00',
                'end_time' => '23:00:00',
                'days_of_week' => json_encode([0, 1, 2, 3, 4, 5, 6]), // All days
                'action' => 'on',
                'is_active' => true,
            ],
            [
                'name' => 'Bedtime',
                'start_time' => '23:00:00',
                'end_time' => '23:59:59',
                'days_of_week' => json_encode([0, 1, 2, 3, 4, 5, 6]), // All days
                'action' => 'off',
                'is_active' => true,
            ],
        ];

        foreach ($schedules as $schedule) {
            Schedule::create($schedule);
        }
    }
}
