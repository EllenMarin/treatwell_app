@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Bookings</h1>
        <a href="{{ route('business.bookings.calendar') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            Calendar View
        </a>
    </div>

    @if(session('status'))
        <div class="bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded mb-4">
            {{ session('status') }}
        </div>
    @endif

    <!-- Filter Tabs -->
    <div class="mb-4 border-b border-gray-200">
        <nav class="-mb-px flex space-x-8">
            <a href="{{ route('business.bookings.index', ['status' => 'all']) }}" 
               class="border-b-2 py-4 px-1 text-sm font-medium {{ request('status', 'all') === 'all' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                All ({{ $statusCounts['all'] }})
            </a>
            <a href="{{ route('business.bookings.index', ['status' => 'pending']) }}" 
               class="border-b-2 py-4 px-1 text-sm font-medium {{ request('status') === 'pending' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Pending ({{ $statusCounts['pending'] }})
            </a>
            <a href="{{ route('business.bookings.index', ['status' => 'confirmed']) }}" 
               class="border-b-2 py-4 px-1 text-sm font-medium {{ request('status') === 'confirmed' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Confirmed ({{ $statusCounts['confirmed'] }})
            </a>
            <a href="{{ route('business.bookings.index', ['status' => 'completed']) }}" 
               class="border-b-2 py-4 px-1 text-sm font-medium {{ request('status') === 'completed' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Completed ({{ $statusCounts['completed'] }})
            </a>
        </nav>
    </div>

    <div class="bg-white rounded shadow">
        @if($bookings->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($bookings as $booking)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $booking->customer_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking->customer_email }}</div>
                                    @if($booking->customer_phone)
                                        <div class="text-xs text-gray-500">{{ $booking->customer_phone }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $booking->plan->name }}</div>
                                    @if($booking->notes)
                                        <div class="text-xs text-gray-500" title="{{ $booking->notes }}">Notes: {{ Str::limit($booking->notes, 30) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $booking->booking_date->format('M j, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking->booking_time->format('g:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $booking->plan->formatted_duration }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $booking->plan->formatted_price }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'confirmed' => 'bg-green-100 text-green-800',
                                            'completed' => 'bg-blue-100 text-blue-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                            'no_show' => 'bg-gray-100 text-gray-800',
                                        ];
                                        $colorClass = $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $colorClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-y-1">
                                    @if($booking->status === 'pending')
                                        <form action="{{ route('business.bookings.confirm', $booking) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900">Confirm</button>
                                        </form>
                                        <span class="text-gray-300">|</span>
                                    @endif
                                    
                                    @if($booking->status === 'confirmed')
                                        <form action="{{ route('business.bookings.complete', $booking) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-blue-600 hover:text-blue-900">Complete</button>
                                        </form>
                                        <span class="text-gray-300">|</span>
                                    @endif
                                    
                                    @if(in_array($booking->status, ['pending', 'confirmed']))
                                        <button onclick="showCancelModal({{ $booking->id }})" class="text-red-600 hover:text-red-900">Cancel</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t">
                {{ $bookings->links() }}
            </div>
        @else
            <div class="p-6 text-center">
                <p class="text-gray-500">No bookings found.</p>
            </div>
        @endif
    </div>
</div>

<!-- Cancel Modal -->
<div id="cancelModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <h3 class="text-lg font-medium mb-4">Cancel Booking</h3>
        <form id="cancelForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1" for="cancellation_reason">Reason for cancellation *</label>
                <textarea id="cancellation_reason" name="cancellation_reason" rows="3" class="w-full border rounded px-3 py-2" required></textarea>
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Cancel Booking
                </button>
                <button type="button" onclick="hideCancelModal()" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                    Close
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showCancelModal(bookingId) {
    document.getElementById('cancelForm').action = `/business/bookings/${bookingId}/cancel`;
    document.getElementById('cancelModal').classList.remove('hidden');
}

function hideCancelModal() {
    document.getElementById('cancelModal').classList.add('hidden');
    document.getElementById('cancellation_reason').value = '';
}
</script>
@endsection

