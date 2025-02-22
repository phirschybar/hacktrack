<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard', ['date' => $prev_month]) }}" 
                   class="px-3 py-1 text-sm bg-gray-700 hover:bg-gray-600 rounded-md">
                    &larr; Previous
                </a>
                
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $current_month_name }}
                </h2>
                
                <a href="{{ route('dashboard', ['date' => $next_month]) }}" 
                   class="px-3 py-1 text-sm bg-gray-700 hover:bg-gray-600 rounded-md">
                    Next &rarr;
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg mb-6">
                        <livewire:weight-chart :chartData="$chartData" />
                    </div>
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left">Day</th>
                                <th class="px-4 py-2 text-left">Weight</th>
                                <th class="px-4 py-2 text-left">Trend</th>
                                <th class="px-4 py-2 text-left">Variation</th>
                                <th class="px-4 py-2 text-left">Exercise Rung</th>
                                <th class="px-4 py-2 text-left">Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($days as $day)
                                <livewire:day-entry :day="$day" :key="$day['date']" />
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
