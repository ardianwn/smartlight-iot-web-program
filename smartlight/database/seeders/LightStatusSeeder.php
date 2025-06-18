<?php

namespace Database\Seeders;

use App\Models\LightStatus;
use DateTime;
use DateInterval;
use Illuminate\Database\Seeder;

class LightStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear previous entries
        LightStatus::truncate();
        
        // Create entries for the past 30 days
        $days = 30;
        $entriesPerDay = 288; // One entry every 5 minutes
        
        // For each day
        for ($day = 0; $day < $days; $day++) {
            $baseDate = date('Y-m-d', strtotime("-{$day} days"));
            
            // For each entry in the day (5 minute intervals)
            for ($entry = 0; $entry < $entriesPerDay; $entry++) {
                $minutes = $entry * 5;
                $timestamp = strtotime($baseDate . " 00:00:00 +{$minutes} minutes");
                $hourOfDay = (int) date('H', $timestamp);
                $isDaytime = $hourOfDay >= 6 && $hourOfDay <= 18;
                
                // Light levels are higher during the day
                $baseValue = $isDaytime ? 3200 : 1000;
                $randomness = $isDaytime ? 800 : 400;
                
                $ldrValue = $baseValue + rand(-$randomness, $randomness);
                $ldrValue = max(0, min(4095, $ldrValue)); // Clamp between 0-4095
                
                // Light is on when dark (LDR value below threshold)
                $isOn = $ldrValue < 2000;
                
                // Randomly simulate manual override in some entries
                $manualOverride = rand(1, 50) === 1; // Less frequent manual overrides
                if ($manualOverride) {
                    $isOn = !$isOn;
                }
                
                LightStatus::create([
                    'is_on' => $isOn,
                    'ldr_value' => $ldrValue,
                    'mode' => $manualOverride ? 'manual' : 'auto',
                    'manual_override' => $manualOverride,
                    'created_at' => date('Y-m-d H:i:s', $timestamp),
                    'updated_at' => date('Y-m-d H:i:s', $timestamp),
                ]);
            }
            
            // For larger datasets, add progress indicator
            if ($day % 5 == 0) {
                $this->command->info("Generated data for day " . ($days - $day) . " days ago");
            }
        }
    }
}
