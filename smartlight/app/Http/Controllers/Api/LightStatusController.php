<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LightStatus;
use App\Models\Schedule;
use App\Models\Setting;
use Illuminate\Http\Request;

class LightStatusController extends Controller
{
    /**
     * Update light status from ESP32
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'is_on' => 'required|boolean',
            'ldr_value' => 'required|integer',
            'mode' => 'required|string|in:auto,manual',
        ]);

        // Check if we should use a schedule right now
        if ($validated['mode'] === 'auto') {
            $activeSchedule = Schedule::where('is_active', true)
                ->get()
                ->first(function ($schedule) {
                    return $schedule->isActiveNow();
                });

            if ($activeSchedule) {
                $validated['manual_override'] = true;
                $validated['is_on'] = $activeSchedule->action_value;
            }
        }

        // Create a new light status entry
        $status = LightStatus::create($validated);

        return response()->json([
            'message' => 'Light status updated',
            'data' => $status,
        ]);
    }

    /**
     * Get the latest light status
     *
     * @return \Illuminate\Http\Response
     */
    public function latest()
    {
        $status = LightStatus::latest()->first();
        $threshold = Setting::get('threshold', 2000);

        // Include settings for the ESP32 to read
        return response()->json([
            'data' => array_merge($status->toArray(), [
                'settings' => [
                    'threshold' => (int)$threshold
                ]
            ]),
        ]);
    }

    /**
     * Toggle the light status manually
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toggle(Request $request)
    {
        $lastStatus = LightStatus::latest()->first();
        
        if (!$lastStatus) {
            return response()->json([
                'message' => 'No status found',
            ], 404);
        }

        $newStatus = LightStatus::create([
            'is_on' => !$lastStatus->is_on,
            'ldr_value' => $lastStatus->ldr_value,
            'mode' => 'manual',
            'manual_override' => true,
        ]);

        return response()->json([
            'message' => 'Light toggled',
            'data' => $newStatus,
        ]);
    }

    /**
     * Set the operation mode (auto/manual)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setMode(Request $request)
    {
        $validated = $request->validate([
            'mode' => 'required|string|in:auto,manual',
        ]);

        $lastStatus = LightStatus::latest()->first();
        
        if (!$lastStatus) {
            return response()->json([
                'message' => 'No status found',
            ], 404);
        }

        $newStatus = LightStatus::create([
            'is_on' => $lastStatus->is_on,
            'ldr_value' => $lastStatus->ldr_value,
            'mode' => $validated['mode'],
            'manual_override' => $validated['mode'] === 'manual',
        ]);

        return response()->json([
            'message' => 'Mode updated to ' . $validated['mode'],
            'data' => $newStatus,
        ]);
    }
}
