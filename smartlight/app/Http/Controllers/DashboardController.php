<?php

namespace App\Http\Controllers;

use App\Models\LightStatus;
use App\Models\Schedule;
use App\Models\Setting;
use App\Services\ExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Show the dashboard
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $latestStatus = LightStatus::latest()->first();
        $schedules = Schedule::all();
        $threshold = Setting::get('threshold', 2000);
        
        // For chart data - get light values for the last 24 hours
        // Use fixed timezone for consistency
        date_default_timezone_set('Asia/Jakarta');
        $yesterday = date('Y-m-d H:i:s', strtotime('-24 hours'));
        
        // Query data from database
        $lightRecords = LightStatus::where('created_at', '>=', $yesterday)
            ->orderBy('created_at')
            ->get();
        
        // Generate all hours for the last 24 hours to ensure all hours are represented
        $hourLabels = [];
        $hourlyDataArray = [];
        
        // Create a range of 24 hour labels from yesterday to now
        for ($i = 0; $i < 24; $i++) {
            // Generate hour keys (H:00 format) for the last 24 hours
            $hourLabel = date('H:00', strtotime("-" . (24 - $i) . " hours"));
            $hourLabels[] = $hourLabel;
            $hourlyDataArray[$hourLabel] = [
                'avg_ldr' => null,
                'count_on' => 0,
                'count_total' => 0,
            ];
        }
        
        // If we have records, process them into hourly buckets
        if ($lightRecords->isNotEmpty()) {
            // Group data by hour
            $groupedData = $lightRecords->groupBy(function ($item) {
                return $item->created_at->format('H:00');
            });
            
            // Calculate metrics for each hour
            foreach ($groupedData as $hour => $group) {
                $hourlyDataArray[$hour] = [
                    'avg_ldr' => round($group->avg('ldr_value') ?? 0, 1),
                    'count_on' => $group->where('is_on', true)->count(),
                    'count_total' => $group->count(),
                ];
            }
        }
        
        // Convert to collection and ensure it's sorted by hour
        $hourlyData = collect($hourlyDataArray);
            
        // Calculate today's light usage in hours
        $today = date('Y-m-d');
        
        // Get today's status records
        $todayRecords = LightStatus::whereDate('created_at', $today)->get();
        
        // If we have records, calculate usage time more accurately
        if ($todayRecords->count() > 0) {
            $onRecords = $todayRecords->where('is_on', true)->count();
            // Each record represents 5 seconds, convert to hours
            $todayUsage = ($onRecords * 5) / 3600; 
        } else {
            $todayUsage = 0;
        }
        
        return view('dashboard', [
            'latestStatus' => $latestStatus,
            'schedules' => $schedules,
            'threshold' => $threshold,
            'hourlyData' => $hourlyData,
            'todayUsage' => round($todayUsage, 1)
        ]);
    }
    
    /**
     * Show the settings page
     */
    public function settings()
    {
        $threshold = Setting::get('threshold', 2000);
        
        return view('settings', [
            'threshold' => $threshold,
        ]);
    }
    
    /**
     * Update settings
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'threshold' => 'required|integer|min:0|max:4095',
        ]);
        
        Setting::set('threshold', $validated['threshold'], 'integer', 'LDR threshold for auto mode');
        
        return redirect()->route('settings')->with('success', 'Settings updated!');
    }
    
    /**
     * Show the schedule page
     */
    public function schedules()
    {
        $schedules = Schedule::all();
        
        return view('schedules', [
            'schedules' => $schedules,
        ]);
    }
    
    /**
     * Store a new schedule
     */
    public function storeSchedule(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
            'days' => 'required|array',
            'days.*' => 'integer|min:0|max:6',
            'action' => 'required|in:on,off',
        ]);
        
        Schedule::create([
            'name' => $validated['name'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'days_of_week' => json_encode($validated['days']),
            'action' => $validated['action'],
            'is_active' => true,
        ]);
        
        return redirect()->route('schedules')->with('success', 'Schedule created!');
    }
    
    /**
     * Update a schedule
     */
    public function updateSchedule(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
            'days' => 'required|array',
            'days.*' => 'integer|min:0|max:6',
            'action' => 'required|in:on,off',
            'is_active' => 'boolean',
        ]);
        
        $schedule->update([
            'name' => $validated['name'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'days_of_week' => json_encode($validated['days']),
            'action' => $validated['action'],
            'is_active' => $request->has('is_active'),
        ]);
        
        return redirect()->route('schedules')->with('success', 'Schedule updated!');
    }
    
    /**
     * Delete a schedule
     */
    public function deleteSchedule(Schedule $schedule)
    {
        $schedule->delete();
        
        return redirect()->route('schedules')->with('success', 'Schedule deleted!');
    }
    
    /**
     * Export light status data
     *
     * @param string $period day|week|month
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|\Illuminate\Http\Response
     */
    public function exportData($period = 'day')
    {
        // Validate period
        if (!in_array($period, ['day', 'week', 'month'])) {
            $period = 'day';
        }
        
        $exportService = new ExportService();
        $filePath = $exportService->exportLightStatusToCsv($period);
        
        return Storage::download($filePath, basename($filePath));
    }
    
    /**
     * Show the reports page
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function reports(Request $request)
    {        $period = $request->query('period', 'day');

        // Validate period
        if (!in_array($period, ['day', 'week', 'month'])) {
            $period = 'day';
        }
        
        $exportService = new ExportService();
        $report = $exportService->generateSummaryReport($period);
        
        // Ensure daily_usage is always an array
        if (!isset($report['daily_usage']) || !is_array($report['daily_usage'])) {
            $report['daily_usage'] = [];
        }
        
        // Check if we have data
        if (empty($report['daily_usage'])) {
            Log::info('No light status data available for report period: ' . $period);
            $report['is_empty'] = true;
            
            // Set mode percentages to zero if not set
            if (!isset($report['auto_percentage'])) {
                $report['auto_percentage'] = 0;
                $report['manual_percentage'] = 0;
            }
        } else {
            $report['is_empty'] = false;
            Log::info('Found ' . count($report['daily_usage']) . ' days of data for report period: ' . $period);
        }
        
        return view('reports', [
            'report' => $report,
            'period' => $period
        ]);
    }
}
