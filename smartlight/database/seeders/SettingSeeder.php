<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'threshold',
                'value' => '2000',
                'description' => 'LDR threshold value for auto mode',
                'type' => 'integer'
            ],
            [
                'key' => 'auto_mode_enabled',
                'value' => 'true',
                'description' => 'Enable auto mode based on LDR value',
                'type' => 'boolean'
            ],
            [
                'key' => 'schedule_enabled',
                'value' => 'true',
                'description' => 'Enable scheduling system',
                'type' => 'boolean'
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
