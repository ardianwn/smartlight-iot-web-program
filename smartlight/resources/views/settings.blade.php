<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">Light Settings</h3>
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 dark:bg-green-900 dark:border-green-700 dark:text-green-300 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    
                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        
                        <div class="mb-6">
                            <label for="threshold" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Light Sensor Threshold (0-4095)
                            </label>
                            <div class="flex items-center">
                                <input type="range" 
                                       id="threshold" 
                                       name="threshold" 
                                       min="0" 
                                       max="4095" 
                                       value="{{ $threshold }}" 
                                       class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                                       oninput="updateThresholdValue(this.value)">
                                <span id="thresholdValue" class="ml-4 w-16 text-center text-gray-900 dark:text-gray-100">{{ $threshold }}</span>
                            </div>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Lower value means lights will turn on in brighter conditions. Higher value means lights will turn on only in darker conditions.
                            </p>
                        </div>
                        
                        <div class="mt-8">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">Device Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase mb-2">Connected Devices</h4>
                            <div class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center">
                                    <div class="h-3 w-3 bg-green-500 rounded-full mr-2"></div>
                                    <span class="text-gray-900 dark:text-white font-medium">ESP32 Device</span>
                                </div>
                                <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    <p>IP: 192.168.105.85</p>
                                    <p class="mt-1">Last ping: Just now</p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase mb-2">System Info</h4>
                            <div class="bg-white dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                <p class="text-gray-900 dark:text-white"><span class="font-medium">Server:</span> SmartLight Hub v1.0</p>
                                <p class="text-gray-900 dark:text-white mt-1"><span class="font-medium">ESP32 Firmware:</span> v1.2.0</p>
                                <p class="text-gray-900 dark:text-white mt-1"><span class="font-medium">Last Update:</span> {{ date('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function updateThresholdValue(val) {
            document.getElementById('thresholdValue').innerText = val;
        }
    </script>
</x-app-layout>
