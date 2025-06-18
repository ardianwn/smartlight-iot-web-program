<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Real-time status indicator -->
            <div id="statusIndicator" class="mb-3 text-sm text-right text-gray-500 dark:text-gray-400">
                <span class="inline-flex items-center">
                    <span id="connectionStatus" class="h-2 w-2 rounded-full bg-green-500 mr-1"></span>
                    <span id="connectionText">Live data: Connected</span>
                </span>
                <span id="lastUpdated" class="ml-2">Last updated: just now</span>
            </div>
            
            <!-- Current Status Card -->
            <div class="mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Current Status</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Light Status -->
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-600">
                                <div class="flex justify-between items-center">
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">LIGHT STATUS</h4>
                                    <div class="relative">
                                        <button id="toggleLight" class="focus:outline-none" title="Toggle light manually">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 hover:text-blue-500 dark:hover:text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="mt-2">
                                    <div class="flex items-center">
                                        <div id="lightStatusIndicator" class="h-4 w-4 rounded-full {{ $latestStatus && $latestStatus->is_on ? 'bg-green-500' : 'bg-gray-400' }} mr-2"></div>
                                        <p id="lightStatusText" class="text-2xl font-bold {{ $latestStatus && $latestStatus->is_on ? 'text-green-500' : 'text-gray-400' }}">
                                            {{ $latestStatus && $latestStatus->is_on ? 'ON' : 'OFF' }}
                                        </p>
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2" id="lastUpdateTime">
                                        @if($latestStatus)
                                            Last updated: {{ $latestStatus->created_at->diffForHumans() }}
                                        @else
                                            No data available
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Light Mode -->
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-600">
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">OPERATION MODE</h4>
                                <div class="mt-2">
                                    <p class="text-2xl font-bold text-gray-800 dark:text-white" id="currentMode">
                                        @if($latestStatus)
                                            {{ ucfirst($latestStatus->mode) }}
                                            @if($latestStatus->manual_override)
                                                <span class="text-sm text-blue-500 font-normal ml-2">(Override)</span>
                                            @endif
                                        @else
                                            --
                                        @endif
                                    </p>
                                    <div class="mt-2 flex gap-2">
                                        <button id="autoModeBtn" class="px-3 py-1 text-xs {{ $latestStatus && $latestStatus->mode === 'auto' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200' }} rounded-full" onclick="setMode('auto')">Auto</button>
                                        <button id="manualModeBtn" class="px-3 py-1 text-xs {{ $latestStatus && $latestStatus->mode === 'manual' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200' }} rounded-full" onclick="setMode('manual')">Manual</button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Light Sensor -->
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-600">
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">LDR SENSOR VALUE</h4>
                                <div class="mt-2">
                                    <div class="flex items-baseline">
                                        <p id="ldrValue" class="text-2xl font-bold text-gray-800 dark:text-white">
                                            @if($latestStatus)
                                                {{ $latestStatus->ldr_value }}
                                            @else
                                                --
                                            @endif
                                        </p>
                                        <span class="ml-1 text-sm text-gray-500 dark:text-gray-400">/4095</span>
                                    </div>
                                    <div class="mt-2 w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2.5">
                                        <div id="ldrProgressBar" class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $latestStatus ? ($latestStatus->ldr_value / 4095) * 100 : 0 }}%"></div>
                                    </div>
                                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                        Threshold: <span id="thresholdValue">{{ $threshold }}</span>
                                        <a href="{{ route('settings') }}" class="text-blue-500 hover:text-blue-700 ml-2" title="Adjust threshold">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Today's Usage -->
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-600">
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">TODAY'S USAGE</h4>
                                <div class="mt-2">
                                    <p id="todayUsage" class="text-2xl font-bold text-gray-800 dark:text-white">{{ $todayUsage }} hrs</p>
                                    <div class="mt-2 text-sm">
                                        <span class="text-green-500 dark:text-green-400 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            Estimated savings: <span id="estimatedSavings">0.5</span> kWh
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Light Intensity Chart -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Light Intensity (24h)</h3>
                        <div class="bg-white dark:bg-gray-700 rounded-lg p-4" style="height: 300px;">
                            <canvas id="lightChart" width="400" height="250"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Light Usage Chart -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Light Usage (24h)</h3>
                        <div class="bg-white dark:bg-gray-700 rounded-lg p-4" style="height: 300px;">
                            <canvas id="usageChart" width="400" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Active Schedules -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Active Schedules</h3>
                        <a href="{{ route('schedules') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Manage Schedules
                        </a>
                    </div>
                    
                    @if($schedules->count() > 0)
                        <div class="bg-white dark:bg-gray-700 overflow-hidden border border-gray-200 dark:border-gray-600 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Time</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Days</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Action</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                                    @foreach($schedules as $schedule)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $schedule->name ?? 'Schedule ' . $schedule->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ date('g:i A', strtotime($schedule->start_time)) }} - {{ date('g:i A', strtotime($schedule->end_time)) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                @php
                                                    $days = json_decode($schedule->days_of_week, true);
                                                    $dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                                                    $dayLabels = [];
                                                    foreach($days as $day) {
                                                        $dayLabels[] = $dayNames[$day];
                                                    }
                                                    echo implode(', ', $dayLabels);
                                                @endphp
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                @if($schedule->action == 'on')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                        Turn ON
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                                                        Turn OFF
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                @if($schedule->is_active)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                        Active
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100">
                                                        Inactive
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-white dark:bg-gray-700 rounded-lg p-6 text-center border border-gray-200 dark:border-gray-600">
                            <p class="text-gray-500 dark:text-gray-400">No schedules created yet.</p>
                            <a href="{{ route('schedules') }}" class="mt-2 inline-block text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                Create your first schedule
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        // Store chart instances to update them
        let lightChart, usageChart;
        let lastDataFetch = new Date();
        
        // Debug functions to check if charts initialize properly
        function debugChartElement(elementId) {
            const element = document.getElementById(elementId);
            console.log(`Chart element ${elementId} exists:`, !!element);
            if (element) {
                console.log(`Element dimensions:`, element.width, element.height);
                console.log(`Element parent visibility:`, element.parentElement.style.display);
            }
        }
        let pollingInterval;
        let failedAttempts = 0;
        const MAX_FAILED_ATTEMPTS = 3;
        const POLLING_INTERVAL = 5000; // 5 seconds
        
        // Light toggle functionality
        document.getElementById('toggleLight').addEventListener('click', function() {
            console.log('Toggle light button clicked');
            
            // Show processing state
            if (typeof window.showNotification === 'function') {
                window.showNotification(
                    'info',
                    'Processing',
                    'Sending toggle command to light...',
                    1500
                );
            }
            
            fetch('/api/light/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Toggle success:', data);
                updateUIWithLatestStatus(data.data);
                
                // Show success notification
                if (typeof window.showNotification === 'function') {
                    window.showNotification(
                        'success',
                        'Light Toggled',
                        data.data.is_on ? 'Light has been turned ON.' : 'Light has been turned OFF.',
                        3000
                    );
                }
            })
            .catch(error => {
                console.error('Toggle error:', error);
                showConnectionError();
                
                // Show specific error
                if (typeof window.showNotification === 'function') {
                    window.showNotification(
                        'error',
                        'Toggle Failed',
                        'Could not toggle the light. Check browser console for details.',
                        5000
                    );
                }
            });
        });
        
        // Mode change functionality
        function setMode(mode) {
            console.log('Setting mode to:', mode);
            
            // Show processing notification
            if (typeof window.showNotification === 'function') {
                window.showNotification(
                    'info',
                    'Changing Mode',
                    'Switching to ' + (mode === 'auto' ? 'automatic' : 'manual') + ' mode...',
                    1500
                );
            }
            
            fetch('/api/light/mode', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ mode: mode })
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Mode change success:', data);
                updateUIWithLatestStatus(data.data);
                
                // Update button styles
                if (mode === 'auto') {
                    document.getElementById('autoModeBtn').className = 'px-3 py-1 text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full';
                    document.getElementById('manualModeBtn').className = 'px-3 py-1 text-xs bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200 rounded-full';
                    
                    // Show notification
                    if (typeof window.showNotification === 'function') {
                        window.showNotification(
                            'info',
                            'Auto Mode Enabled',
                            'The light will now operate based on ambient light levels and schedules.',
                            3000
                        );
                    }
                } else {
                    document.getElementById('autoModeBtn').className = 'px-3 py-1 text-xs bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200 rounded-full';
                    document.getElementById('manualModeBtn').className = 'px-3 py-1 text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full';
                    
                    // Show notification
                    if (typeof window.showNotification === 'function') {
                        window.showNotification(
                            'info',
                            'Manual Mode Enabled',
                            'The light will now operate based on manual control only.',
                            3000
                        );
                    }
                }
            })
            .catch(error => {
                console.error('Mode change error:', error);
                showConnectionError();
                
                // Show specific error notification
                if (typeof window.showNotification === 'function') {
                    window.showNotification(
                        'error',
                        'Mode Change Failed',
                        'Could not change mode to ' + mode + '. Check browser console for details.',
                        5000
                    );
                }
            });
        }

        // Function to update UI with latest status
        function updateUIWithLatestStatus(status) {
            if (!status) return;
            
            // Update light status
            const isOn = status.is_on;
            document.getElementById('lightStatusIndicator').className = `h-4 w-4 rounded-full ${isOn ? 'bg-green-500' : 'bg-gray-400'} mr-2`;
            document.getElementById('lightStatusText').className = `text-2xl font-bold ${isOn ? 'text-green-500' : 'text-gray-400'}`;
            document.getElementById('lightStatusText').textContent = isOn ? 'ON' : 'OFF';
            
            // Update mode
            let modeText = status.mode.charAt(0).toUpperCase() + status.mode.slice(1);
            if (status.manual_override) {
                modeText += ' <span class="text-sm text-blue-500 font-normal ml-2">(Override)</span>';
            }
            document.getElementById('currentMode').innerHTML = modeText;
            
            // Update LDR value and progress bar
            document.getElementById('ldrValue').textContent = status.ldr_value;
            document.getElementById('ldrProgressBar').style.width = `${(status.ldr_value / 4095) * 100}%`;
            
            // Update last updated time
            const createdAt = new Date(status.created_at);
            const now = new Date();
            const diffMs = now - createdAt;
            const diffMins = Math.round(diffMs / 60000);
            
            let timeText;
            if (diffMins < 1) {
                timeText = 'just now';
            } else if (diffMins === 1) {
                timeText = '1 minute ago';
            } else if (diffMins < 60) {
                timeText = `${diffMins} minutes ago`;
            } else {
                const diffHours = Math.floor(diffMins / 60);
                if (diffHours === 1) {
                    timeText = '1 hour ago';
                } else {
                    timeText = `${diffHours} hours ago`;
                }
            }
            
            document.getElementById('lastUpdateTime').textContent = `Last updated: ${timeText}`;
            
            // Update last data fetch time
            lastDataFetch = now;
            document.getElementById('lastUpdated').textContent = `Last updated: just now`;
            
            // Reset connection status
            showConnected();
        }
        
        // Function to fetch latest status
        function fetchLatestStatus() {
            fetch('/api/light/status')
                .then(response => response.json())
                .then(data => {
                    if (data.data) {
                        updateUIWithLatestStatus(data.data);
                        failedAttempts = 0;
                    }
                })
                .catch(error => {
                    console.error('Error fetching status:', error);
                    failedAttempts++;
                    
                    if (failedAttempts >= MAX_FAILED_ATTEMPTS) {
                        showConnectionError();
                    }
                });
        }
        
        // Show connected state
        function showConnected() {
            document.getElementById('connectionStatus').className = 'h-2 w-2 rounded-full bg-green-500 mr-1';
            document.getElementById('connectionText').textContent = 'Live data: Connected';
        }
        
        // Show connection error
        function showConnectionError() {
            document.getElementById('connectionStatus').className = 'h-2 w-2 rounded-full bg-red-500 mr-1';
            document.getElementById('connectionText').textContent = 'Live data: Disconnected';
            
            // Show notification if available
            if (typeof window.showNotification === 'function') {
                window.showNotification(
                    'error',
                    'Connection Lost',
                    'Unable to communicate with the Smart Light device. Please check your device connection.',
                    10000
                );
            }
        }

        // Charts
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Content Loaded - Initializing charts');
            debugChartElement('lightChart');
            debugChartElement('usageChart');
            
            // Ensure data exists
            const hourlyData = @json($hourlyData) || {};
            console.log('Hourly data loaded:', hourlyData);
            
            const hours = Object.keys(hourlyData);
            
            // Create LDR values array with proper handling of null/empty values
            const ldrValues = hours.map(hour => {
                const value = hourlyData[hour]?.avg_ldr;
                // Return null for missing values so the chart doesn't connect these points
                return value !== undefined && value !== null ? value : null;
            });
            
            // Calculate usage percentages more accurately
            const usagePercentages = hours.map(hour => {
                const total = hourlyData[hour]?.count_total || 0;
                if (total === 0) return 0;
                const percentage = ((hourlyData[hour]?.count_on || 0) / total) * 100;
                return Math.round(percentage * 10) / 10; // Round to 1 decimal place
            });
            
            console.log('Chart data prepared:', { hours, ldrValues, usagePercentages });
            
            // Light intensity chart
            try {
                const lightCtx = document.getElementById('lightChart').getContext('2d');
                lightChart = new Chart(lightCtx, {
                type: 'line',
                data: {
                    labels: hours,
                    datasets: [{
                        label: 'LDR Value',
                        data: ldrValues,
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.3,
                        spanGaps: true // Connect the line across null values
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 4095,
                            title: {
                                display: true,
                                text: 'Sensor Value'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Time (24h)'
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw;
                                    if (value === null) return 'No data';
                                    return `LDR Value: ${value}`;
                                }
                            }
                        }
                    }
                }
            });
                console.log('Light chart initialized successfully');
            } catch (error) {
                console.error('Error initializing light chart:', error);
            }
            
            // Usage chart
            try {
                const usageCtx = document.getElementById('usageChart').getContext('2d');
                usageChart = new Chart(usageCtx, {
                type: 'bar',
                data: {
                    labels: hours,
                    datasets: [{
                        label: 'Light ON (%)',
                        data: usagePercentages,
                        backgroundColor: 'rgba(16, 185, 129, 0.7)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            title: {
                                display: true,
                                text: 'Percentage'
                            },
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                }
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Time (24h)'
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `ON: ${context.raw}%`;
                                }
                            }
                        }
                    }
                }
            });
                console.log('Usage chart initialized successfully');
            } catch (error) {
                console.error('Error initializing usage chart:', error);
            }
            
            // Start polling for updates
            pollingInterval = setInterval(fetchLatestStatus, POLLING_INTERVAL);
            
            // Update the "last updated" text every minute
            setInterval(function() {
                const now = new Date();
                const diffMs = now - lastDataFetch;
                const diffMins = Math.round(diffMs / 60000);
                
                if (diffMins < 1) {
                    document.getElementById('lastUpdated').textContent = 'Last updated: just now';
                } else if (diffMins === 1) {
                    document.getElementById('lastUpdated').textContent = 'Last updated: 1 minute ago';
                } else {
                    document.getElementById('lastUpdated').textContent = `Last updated: ${diffMins} minutes ago`;
                }
                
                // If it's been more than 3 minutes since the last update, show disconnected
                if (diffMins >= 3) {
                    showConnectionError();
                }
            }, 60000); // Check every minute
        });
        
        // Clean up intervals when leaving the page
        window.addEventListener('beforeunload', function() {
            clearInterval(pollingInterval);
        });
    </script>
    @endpush
</x-app-layout>
