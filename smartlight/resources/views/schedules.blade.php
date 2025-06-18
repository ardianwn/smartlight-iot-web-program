<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Schedules') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 dark:bg-green-900 dark:border-green-700 dark:text-green-300 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            <!-- Create New Schedule -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">Create New Schedule</h3>
                    
                    <form action="{{ route('schedules.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Schedule Name
                                </label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                                       placeholder="Morning Routine"
                                       required>
                            </div>
                            
                            <div>
                                <label for="action" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Action
                                </label>
                                <select name="action" 
                                        id="action" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        required>
                                    <option value="on">Turn ON</option>
                                    <option value="off">Turn OFF</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Start Time
                                </label>
                                <input type="time" 
                                       name="start_time" 
                                       id="start_time" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                       required>
                            </div>
                            
                            <div>
                                <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    End Time
                                </label>
                                <input type="time" 
                                       name="end_time" 
                                       id="end_time" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                       required>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Days of Week
                            </label>
                            <div class="grid grid-cols-7 gap-2">
                                @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $index => $day)
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               id="day{{ $index }}" 
                                               name="days[]" 
                                               value="{{ $index }}" 
                                               class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="day{{ $index }}" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                            {{ substr($day, 0, 3) }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Create Schedule
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Existing Schedules -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">Your Schedules</h3>
                    
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
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Manage</th>
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
                                                <form action="{{ route('schedules.update', $schedule) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="name" value="{{ $schedule->name }}">
                                                    <input type="hidden" name="start_time" value="{{ $schedule->start_time }}">
                                                    <input type="hidden" name="end_time" value="{{ $schedule->end_time }}">
                                                    <input type="hidden" name="action" value="{{ $schedule->action }}">
                                                    @foreach(json_decode($schedule->days_of_week) as $day)
                                                        <input type="hidden" name="days[]" value="{{ $day }}">
                                                    @endforeach
                                                    <input type="hidden" name="is_active" value="{{ $schedule->is_active ? '0' : '1' }}">
                                                    <button type="submit" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $schedule->is_active ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100' }}">
                                                        {{ $schedule->is_active ? 'Active' : 'Inactive' }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button type="button" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 mr-3" 
                                                        onclick="openEditModal('{{ $schedule->id }}')">
                                                    Edit
                                                </button>
                                                <form action="{{ route('schedules.destroy', $schedule) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 dark:text-red-400 hover:text-red-900"
                                                            onclick="return confirm('Are you sure you want to delete this schedule?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-white dark:bg-gray-700 rounded-lg p-6 text-center border border-gray-200 dark:border-gray-600">
                            <p class="text-gray-500 dark:text-gray-400">You haven't created any schedules yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Schedule Modal -->
    <div id="editScheduleModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div id="modalOverlay" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            
            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                                Edit Schedule
                            </h3>
                            
                            <form id="editScheduleForm" method="POST" class="mt-6">
                                @csrf
                                @method('PUT')
                                
                                <div class="grid grid-cols-1 gap-6">
                                    <div>
                                        <label for="edit_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Schedule Name
                                        </label>
                                        <input type="text" 
                                               name="name" 
                                               id="edit_name" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                                               required>
                                    </div>
                                    
                                    <div>
                                        <label for="edit_action" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Action
                                        </label>
                                        <select name="action" 
                                                id="edit_action" 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                                required>
                                            <option value="on">Turn ON</option>
                                            <option value="off">Turn OFF</option>
                                        </select>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="edit_start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Start Time
                                            </label>
                                            <input type="time" 
                                                   name="start_time" 
                                                   id="edit_start_time" 
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                                   required>
                                        </div>
                                        
                                        <div>
                                            <label for="edit_end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                End Time
                                            </label>
                                            <input type="time" 
                                                   name="end_time" 
                                                   id="edit_end_time" 
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                                   required>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Days of Week
                                        </label>
                                        <div class="grid grid-cols-7 gap-2">
                                            @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $index => $day)
                                                <div class="flex items-center">
                                                    <input type="checkbox" 
                                                           id="edit_day{{ $index }}" 
                                                           name="days[]" 
                                                           value="{{ $index }}" 
                                                           class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                                                    <label for="edit_day{{ $index }}" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                                        {{ substr($day, 0, 3) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               id="edit_is_active" 
                                               name="is_active" 
                                               value="1" 
                                               class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="edit_is_active" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" 
                            id="saveEditBtn"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Save Changes
                    </button>
                    <button type="button" 
                            id="cancelEditBtn"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Store schedule data in a JavaScript object for easy access
        const scheduleData = {
            @foreach($schedules as $schedule)
            '{{ $schedule->id }}': {
                name: "{{ $schedule->name ?? 'Schedule ' . $schedule->id }}",
                start_time: "{{ $schedule->start_time }}",
                end_time: "{{ $schedule->end_time }}",
                action: "{{ $schedule->action }}",
                is_active: {{ $schedule->is_active ? 'true' : 'false' }},
                days: @json(json_decode($schedule->days_of_week, true))
            },
            @endforeach
        };

        function openEditModal(id) {
            const schedule = scheduleData[id];
            if (!schedule) return;
            
            // Populate form with schedule data
            document.getElementById('edit_name').value = schedule.name;
            document.getElementById('edit_action').value = schedule.action;
            document.getElementById('edit_start_time').value = schedule.start_time;
            document.getElementById('edit_end_time').value = schedule.end_time;
            document.getElementById('edit_is_active').checked = schedule.is_active;
            
            // Reset all day checkboxes first
            for (let i = 0; i < 7; i++) {
                document.getElementById(`edit_day${i}`).checked = false;
            }
            
            // Check the days that are in the schedule
            schedule.days.forEach(day => {
                document.getElementById(`edit_day${day}`).checked = true;
            });
            
            // Set form action
            document.getElementById('editScheduleForm').action = `/schedules/${id}`;
            
            // Show modal
            document.getElementById('editScheduleModal').classList.remove('hidden');
        }

        // Close modal when clicking on overlay
        document.getElementById('modalOverlay').addEventListener('click', function() {
            document.getElementById('editScheduleModal').classList.add('hidden');
        });

        // Close modal when clicking cancel button
        document.getElementById('cancelEditBtn').addEventListener('click', function() {
            document.getElementById('editScheduleModal').classList.add('hidden');
        });

        // Submit form when clicking save button
        document.getElementById('saveEditBtn').addEventListener('click', function() {
            document.getElementById('editScheduleForm').submit();
        });
    </script>
</x-app-layout>
