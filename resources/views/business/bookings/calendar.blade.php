@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Booking Calendar</h1>
        <a href="{{ route('business.bookings.index') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            List View
        </a>
    </div>

    <!-- Month Navigation -->
    <div class="bg-white rounded shadow p-4 mb-4">
        <div class="flex justify-between items-center">
            <a href="{{ route('business.bookings.calendar', ['month' => $startDate->copy()->subMonth()->month, 'year' => $startDate->copy()->subMonth()->year]) }}" 
               class="text-indigo-600 hover:text-indigo-800">
                ← Previous Month
            </a>
            <h2 class="text-xl font-semibold">{{ $startDate->format('F Y') }}</h2>
            <a href="{{ route('business.bookings.calendar', ['month' => $startDate->copy()->addMonth()->month, 'year' => $startDate->copy()->addMonth()->year]) }}" 
               class="text-indigo-600 hover:text-indigo-800">
                Next Month →
            </a>
        </div>
    </div>

    <!-- Calendar Grid -->
    <div class="bg-white rounded shadow overflow-hidden">
        <div class="grid grid-cols-7 gap-px bg-gray-200">
            <!-- Day Headers -->
            @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                <div class="bg-gray-50 p-2 text-center text-sm font-semibold text-gray-700">
                    {{ $day }}
                </div>
            @endforeach

            <!-- Calendar Days -->
            @php
                $currentDate = $startDate->copy()->startOfWeek();
                $endOfCalendar = $endDate->copy()->endOfWeek();
            @endphp

            @while($currentDate <= $endOfCalendar)
                @php
                    $dateKey = $currentDate->format('Y-m-d');
                    $dayBookings = $bookings->get($dateKey, collect());
                    $isCurrentMonth = $currentDate->month === $startDate->month;
                    $isToday = $currentDate->isToday();
                @endphp

                <div class="bg-white p-2 min-h-[120px] {{ !$isCurrentMonth ? 'bg-gray-50' : '' }} {{ $isToday ? 'ring-2 ring-indigo-500' : '' }}">
                    <div class="text-sm font-semibold mb-1 {{ !$isCurrentMonth ? 'text-gray-400' : 'text-gray-900' }}">
                        {{ $currentDate->day }}
                    </div>

                    @if($dayBookings->count() > 0)
                        <div class="space-y-1">
                            @foreach($dayBookings->take(3) as $booking)
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                                        'confirmed' => 'bg-green-100 text-green-800 border-green-300',
                                        'completed' => 'bg-blue-100 text-blue-800 border-blue-300',
                                        'cancelled' => 'bg-red-100 text-red-800 border-red-300',
                                    ];
                                    $colorClass = $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800 border-gray-300';
                                @endphp
                                <div class="text-xs p-1 rounded border {{ $colorClass }}" title="{{ $booking->customer_name }} - {{ $booking->plan->name }}">
                                    <div class="font-semibold">{{ $booking->booking_time->format('g:i A') }}</div>
                                    <div class="truncate">{{ $booking->customer_name }}</div>
                                    <div class="truncate text-[10px]">{{ $booking->plan->name }}</div>
                                </div>
                            @endforeach

                            @if($dayBookings->count() > 3)
                                <div class="text-xs text-gray-500 text-center">
                                    +{{ $dayBookings->count() - 3 }} more
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                @php
                    $currentDate->addDay();
                @endphp
            @endwhile
        </div>
    </div>

    <!-- Legend -->
    <div class="mt-4 bg-white rounded shadow p-4">
        <h3 class="text-sm font-semibold mb-2">Legend:</h3>
        <div class="flex flex-wrap gap-4 text-xs">
            <div class="flex items-center">
                <span class="inline-block w-4 h-4 bg-yellow-100 border border-yellow-300 rounded mr-1"></span>
                Pending
            </div>
            <div class="flex items-center">
                <span class="inline-block w-4 h-4 bg-green-100 border border-green-300 rounded mr-1"></span>
                Confirmed
            </div>
            <div class="flex items-center">
                <span class="inline-block w-4 h-4 bg-blue-100 border border-blue-300 rounded mr-1"></span>
                Completed
            </div>
            <div class="flex items-center">
                <span class="inline-block w-4 h-4 bg-red-100 border border-red-300 rounded mr-1"></span>
                Cancelled
            </div>
        </div>
    </div>
</div>
@endsection

