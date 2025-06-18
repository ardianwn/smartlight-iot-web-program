<?php

namespace App\Services;

use App\Models\LightStatus;
use Illuminate\Support\Facades\Log;
use illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ExportService
{
    /**
     * Export light status data to CSV
     *
     * @param string $period 'day', 'week', 'month'
     * @return string The path to the exported file
     */
    public function exportLightStatusToCsv($period = 'day')
    {
        // Determine date range
        date_default_timezone_set('Asia/Jakarta');
        $endDate = date('Y-m-d H:i:s');
        
        // Calculate start date based on period
        if ($period === 'week') {
            $startDate = date('Y-m-d H:i:s', strtotime('-1 week'));
        } elseif ($period === 'month') {
            $startDate = date('Y-m-d H:i:s', strtotime('-1 month'));
        } else {
            $startDate = date('Y-m-d H:i:s', strtotime('-1 day'));
        }

        // Get data
        $lightData = LightStatus::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at')
            ->get();

        // CSV headers
        $headers = [
            'Date/Time',
            'Status',
            'LDR Value',
            'Mode',
            'Manual Override'
        ];

        // Prepare CSV data
        $csvData = [];
        $csvData[] = implode(',', $headers);

        foreach ($lightData as $record) {
            $csvData[] = implode(',', [
                $record->created_at->format('Y-m-d H:i:s'),
                $record->is_on ? 'ON' : 'OFF',
                $record->ldr_value,
                $record->mode,
                $record->manual_override ? 'Yes' : 'No'
            ]);
        }

        // File path and name
        $fileName = 'light_status_' . $period . '_' . date('Y-m-d_H-i-s') . '.csv';
        $filePath = 'exports/' . $fileName;

        // Save to storage
        Storage::put($filePath, implode("\n", $csvData));

        return $filePath;
    }

    /**
     * Generate a summary report of light usage
     *
     * @param string $period 'day', 'week', 'month'
     * @return array Summary data
     */
    public function generateSummaryReport($period = 'day')
    {
        // Determine date range
        date_default_timezone_set('Asia/Jakarta');
        $endDate = date('Y-m-d H:i:s');
        
        // Calculate start date based on period
        $startDate = match ($period) {
            'week' => date('Y-m-d H:i:s', strtotime('-1 week')),
            'month' => date('Y-m-d H:i:s', strtotime('-1 month')),
            default => date('Y-m-d H:i:s', strtotime('-1 day'))
        };

        // Get data with error logging
        try {
            $lightData = LightStatus::whereBetween('created_at', [$startDate, $endDate])->get();
            Log::info("ExportService: Found {$lightData->count()} records for period {$period} between {$startDate} and {$endDate}");
        } catch (\Exception $e) {
            Log::error("ExportService: Error querying light status data: " . $e->getMessage());
            $lightData = collect([]);
        }

        // Calculate total records and ON records
        $totalRecords = $lightData->count();
        $onRecords = $lightData->where('is_on', true)->count();
        
        // Each record represents 5 seconds (sampling rate)
        $totalTimeOn = ($onRecords * 5) / 3600; // Convert to hours
        
        // Percentage of time light was ON
        $percentageOn = $totalRecords > 0 ? round(($onRecords / $totalRecords) * 100, 1) : 0;
        
        // Average LDR value
        $avgLdr = $lightData->avg('ldr_value') ?? 0;
        
        // Auto vs Manual usage
        $autoRecords = $lightData->where('mode', 'auto')->count();
        $manualRecords = $lightData->where('mode', 'manual')->count();
        $autoPercentage = $totalRecords > 0 ? round(($autoRecords / $totalRecords) * 100, 1) : 0;
        $manualPercentage = $totalRecords > 0 ? round(($manualRecords / $totalRecords) * 100, 1) : 0;
        
        // Group by day
        $dailyUsage = $lightData->isEmpty() ? [] : $lightData->groupBy(function($item) {
            return $item->created_at->format('Y-m-d');
        })->map(function($group) {
            $totalRecords = $group->count();
            $onRecords = $group->where('is_on', true)->count();
            $hoursOn = ($onRecords * 5) / 3600;
            
            return [
                'date' => $group->first()->created_at->format('Y-m-d'),
                'hours_on' => round($hoursOn, 2),
                'percentage_on' => $totalRecords > 0 ? round(($onRecords / $totalRecords) * 100, 1) : 0,
                'avg_ldr' => round($group->avg('ldr_value') ?? 0, 1)
            ];
        })->values()->all(); // Convert to indexed array

        return [
            'period' => $period,
            'start_date' => date('Y-m-d', strtotime($startDate)),
            'end_date' => date('Y-m-d', strtotime($endDate)),
            'total_hours_on' => round($totalTimeOn, 2),
            'percentage_on' => $percentageOn,
            'avg_ldr' => round($avgLdr, 1),
            'auto_percentage' => $autoPercentage,
            'manual_percentage' => $manualPercentage,
            'daily_usage' => $dailyUsage,
        ];
    }
}
