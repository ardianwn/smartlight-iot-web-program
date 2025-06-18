<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Reports & Analytics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Report Period Selection -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Select Report Period</h3>
                    
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('reports', ['period' => 'day']) }}" class="px-4 py-2 rounded-md {{ $period === 'day' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200' }}">
                            Last 24 Hours
                        </a>
                        <a href="{{ route('reports', ['period' => 'week']) }}" class="px-4 py-2 rounded-md {{ $period === 'week' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200' }}">
                            Last Week
                        </a>
                        <a href="{{ route('reports', ['period' => 'month']) }}" class="px-4 py-2 rounded-md {{ $period === 'month' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200' }}">
                            Last Month
                        </a>
                        
                        <div class="ml-auto flex gap-3">
                            <a href="{{ route('export', ['period' => $period]) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Export CSV
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <!-- Total Hours On -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">TOTAL HOURS ON</h3>
                        <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2">{{ $report['total_hours_on'] }} hrs</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                            Light was ON {{ $report['percentage_on'] }}% of the time
                        </p>
                    </div>
                </div>
                
                <!-- Average LDR -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">AVERAGE LIGHT INTENSITY</h3>
                        <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2">{{ $report['avg_ldr'] }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                            Average LDR sensor value
                        </p>
                    </div>
                </div>
                
                <!-- Mode Usage -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">MODE USAGE</h3>
                        <div class="flex items-center gap-4 mt-2">
                            <div style="width: 120px; height: 120px; position: relative;">
                                <canvas id="modeChart" width="120" height="120"></canvas>
                            </div>
                            <div>
                                <div class="flex items-center mb-1">
                                    <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Auto: {{ $report['auto_percentage'] }}%</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-3 h-3 bg-orange-500 rounded-full mr-2"></span>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Manual: {{ $report['manual_percentage'] }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Report Period -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">REPORT PERIOD</h3>
                        <p class="text-xl font-bold text-gray-800 dark:text-white mt-2">
                            {{ ucfirst($period) }} Report
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                            {{ $report['start_date'] }} to {{ $report['end_date'] }}
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Daily Usage Chart -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Daily Usage</h3>
                    <div class="bg-white dark:bg-gray-700 rounded-lg p-4" style="height: 400px; position: relative;">
                        <canvas id="dailyUsageChart" width="400" height="350"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Daily Usage Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Daily Breakdown</h3>
                    
                    <div class="bg-white dark:bg-gray-700 overflow-hidden border border-gray-200 dark:border-gray-600 sm:rounded-lg">
                        @if(count($report['daily_usage']) > 0)
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Hours On</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Percentage On</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Avg Light Intensity</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                                    @foreach($report['daily_usage'] as $day)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $day['date'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $day['hours_on'] }} hrs</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $day['percentage_on'] }}%</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $day['avg_ldr'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="p-6 text-center">
                                <p class="text-gray-500 dark:text-gray-400">No data available for the selected period.</p>
                                <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">Data will appear here once the smart light system records more activity.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        // Debug function to check chart elements
        function debugChartElement(elementId) {
            const element = document.getElementById(elementId);
            console.log(`Chart element ${elementId} exists:`, !!element);
            if (element) {
                console.log(`Element dimensions:`, element.width, element.height);
                console.log(`Element parent visibility:`, element.parentElement.style.display);
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Content Loaded in Reports - Initializing charts');
            debugChartElement('modeChart');
            debugChartElement('dailyUsageChart');
            
            // Mode usage chart
            try {
                const modeCtx = document.getElementById('modeChart');
                if (!modeCtx) {
                    throw new Error('Mode chart canvas not found');
                }
                
                const ctx = modeCtx.getContext('2d');
                if (!ctx) {
                    throw new Error('Could not get 2d context for mode chart');
                }
                
                // Get percentages with safe defaults
                let autoPercentage = {{ $report['auto_percentage'] ?? 0 }};
                let manualPercentage = {{ $report['manual_percentage'] ?? 0 }};
                
                // Ensure we always have some value to show
                if (autoPercentage === 0 && manualPercentage === 0) {
                    // If both are zero, set defaults to avoid empty chart
                    autoPercentage = 50;
                    manualPercentage = 50;
                    console.log('Setting default mode values for empty chart');
                }
                
                console.log('Mode chart data:', {autoPercentage, manualPercentage});
                
                // Flag for no real data
                const noData = {{ isset($report['auto_percentage']) && isset($report['manual_percentage']) ? 'false' : 'true' }};
                
                new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Auto', 'Manual'],
                    datasets: [{
                        data: [autoPercentage, manualPercentage],
                        backgroundColor: ['#3b82f6', '#f97316'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw;
                                    if (noData && value === 0) {
                                        return 'No data available';
                                    }
                                    const label = context.label || '';
                                    return `${label}: ${value}%`;
                                }
                            }
                        }
                    },
                    cutout: '70%'
                }
            });
                console.log('Mode chart initialized successfully');
            } catch (error) {
                console.error('Error initializing mode chart:', error);
            }
            
            // Daily usage chart
            try {
                const dailyUsageCanvas = document.getElementById('dailyUsageChart');
                if (!dailyUsageCanvas) {
                    throw new Error('Daily usage chart canvas not found');
                }
                
                const dailyUsageCtx = dailyUsageCanvas.getContext('2d');
                if (!dailyUsageCtx) {
                    throw new Error('Could not get 2d context for daily usage chart');
                }
                
                const dailyData = @json($report['daily_usage'] ?? []);
                console.log('Daily usage data:', dailyData);
                
                let dates = [];
                let hoursOn = [];
                let avgLdr = [];
                
                // Check if data is available in a more robust way
                if (!dailyData || !Array.isArray(dailyData) || dailyData.length === 0) {
                    console.log('No daily usage data available');
                    
                    // Create a message element that replaces the chart
                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'text-center py-10 text-gray-500 dark:text-gray-400';
                    messageDiv.innerHTML = 'No data available for the selected period. <br><span class="text-sm mt-2 block">Please check the database for light status records.</span>';
                    
                    // Get the chart container and replace it
                    const chartContainer = dailyUsageCanvas.parentElement;
                    chartContainer.innerHTML = '';
                    chartContainer.appendChild(messageDiv);
                    
                    const refreshButton = document.createElement('button');
                    refreshButton.className = 'mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700';
                    refreshButton.textContent = 'Refresh Page';
                    refreshButton.onclick = () => window.location.reload();
                    messageDiv.appendChild(refreshButton);
                    
                    console.log('Replaced chart with message');
                    return;
                }
                
                // Extract data with fallback values and add debug info
                try {
                    dates = dailyData.map(day => day.date || 'Unknown Date');
                    hoursOn = dailyData.map(day => day.hours_on || 0);
                    avgLdr = dailyData.map(day => day.avg_ldr || 0);
                    
                    console.log('Extracted chart data:', { 
                        dates, 
                        hoursOn, 
                        avgLdr,
                        dailyDataType: typeof dailyData,
                        samplesAvailable: dailyData.length
                    });
                    
                    // Validate data integrity
                    if (dates.length === 0 || hoursOn.length === 0) {
                        throw new Error('Chart data arrays are empty');
                    }
                } catch (error) {
                    console.error('Error extracting chart data:', error);
                    
                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'text-center py-10 text-red-500';
                    messageDiv.innerHTML = `Error processing chart data: ${error.message}`;
                    
                    const chartContainer = dailyUsageCanvas.parentElement;
                    chartContainer.innerHTML = '';
                    chartContainer.appendChild(messageDiv);
                    return;
                }
                
                // Create the daily usage chart with empty checks
                console.log('Creating daily usage chart with dates:', dates);
                
                // Check if dates array exists and has items
                if (!dates || dates.length === 0) {
                    console.error('Dates array is empty or undefined');
                    throw new Error('No valid dates available for chart');
                }
                
                const dailyUsageChart = new Chart(dailyUsageCtx, {
                    type: 'bar',
                    data: {
                        labels: dates,
                        datasets: [
                            {
                                label: 'Hours On',
                                data: hoursOn,
                                backgroundColor: 'rgba(16, 185, 129, 0.7)',
                                borderColor: 'rgba(16, 185, 129, 1)',
                                borderWidth: 1,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Avg Light Intensity',
                                data: avgLdr,
                                type: 'line',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                borderColor: 'rgba(59, 130, 246, 1)',
                                borderWidth: 2,
                                fill: false,
                                tension: 0.3,
                                yAxisID: 'y1'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 1000 // General animation time
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Hours',
                                    color: 'rgba(16, 185, 129, 1)'
                                },
                                ticks: {
                                    precision: 1
                                }
                            },
                            y1: {
                                beginAtZero: true,
                                position: 'right',
                                grid: {
                                    drawOnChartArea: false
                                },
                                title: {
                                    display: true,
                                    text: 'Light Intensity',
                                    color: 'rgba(59, 130, 246, 1)'
                                },
                                max: 4095
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.datasetIndex === 0) {
                                            return label + context.raw + ' hours';
                                        } else {
                                            return label + context.raw + ' LDR value';
                                        }
                                    }
                                }
                            }
                        }
                    }
                });
            console.log('Daily usage chart initialized successfully');
                
                // Add a checker to verify chart was created properly
                setTimeout(() => {
                    if (dailyUsageChart && dailyUsageChart.canvas) {
                        console.log('Chart canvas is properly attached to DOM');
                    } else {
                        console.error('Chart canvas might not be properly attached, attempting to refresh');
                        dailyUsageChart.update();
                    }
                }, 500);
                
            } catch (error) {
                console.error('Error initializing daily usage chart:', error);
                const chartContainer = document.getElementById('dailyUsageChart').parentElement;
                chartContainer.innerHTML = 
                    '<div class="text-center py-6 text-red-500 dark:text-red-400">' +
                    '<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">' +
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />' +
                    '</svg>' +
                    '<p class="text-lg font-medium">Failed to load chart</p>' +
                    '<p class="text-sm mt-1">' + error.message + '</p>' +
                    '<button onclick="window.location.reload()" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Refresh Page</button>' +
                    '</div>';
            }
        });
    </script>
    
    <!-- Fallback script to ensure Chart.js is loaded -->
    <script>
        window.addEventListener('load', function() {
            if (typeof Chart === 'undefined') {
                console.error('Chart.js not loaded. Loading from fallback source...');
                var script = document.createElement('script');
                script.src = 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js';
                script.integrity = 'sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==';
                script.crossOrigin = 'anonymous';
                script.referrerPolicy = 'no-referrer';
                script.onload = function() {
                    console.log('Chart.js loaded successfully from fallback source');
                    document.dispatchEvent(new Event('DOMContentLoaded'));
                };
                document.head.appendChild(script);
            }
        });
    </script>
    @endpush
</x-app-layout>
