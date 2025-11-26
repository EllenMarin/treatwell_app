@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Customer Dashboard</h1>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="bg-white p-6 rounded shadow">
        <h2 class="font-semibold text-lg mb-4">Upcoming Bookings</h2>
        
        @if($upcomingBookings->count() > 0)
            <div class="space-y-3">
                @foreach($upcomingBookings as $booking)
                    <div class="border-l-4 border-indigo-500 pl-3 py-2">
                        <div class="font-semibold">{{ $booking->business->name }}</div>
                        <div class="text-sm text-gray-600">{{ $booking->plan->name }}</div>
                        <div class="text-sm text-gray-500">
                            {{ $booking->booking_date->format('M j, Y') }} at {{ $booking->booking_time->format('g:i A') }}
                        </div>
                        <div class="text-xs mt-1">
                            <span class="px-2 py-1 rounded {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <a href="{{ route('customer.bookings.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 mt-3 inline-block">
                View All Bookings →
            </a>
        @else
            <p class="text-gray-500 text-sm">You have no upcoming bookings.</p>
            <a href="{{ route('customer.bookings.create') }}" class="text-sm text-indigo-600 hover:text-indigo-800 mt-2 inline-block">
                Book an Appointment →
            </a>
        @endif
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h2 class="font-semibold text-lg mb-4">Quick Actions</h2>
        <div class="space-y-2">
            <a href="{{ route('customer.bookings.create') }}" class="block text-indigo-600 hover:text-indigo-800">
                → Book New Appointment
            </a>
            <a href="{{ route('customer.bookings.index') }}" class="block text-indigo-600 hover:text-indigo-800">
                → View My Bookings
            </a>
        </div>
    </div>
</div>

<div class="bg-white p-6 rounded shadow">
    <h2 class="font-semibold text-lg mb-4">Featured Businesses</h2>
    
    @if($recentBusinesses->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($recentBusinesses as $business)
                <div class="border rounded p-4 hover:shadow-md transition">
                    <h3 class="font-semibold mb-2">{{ $business->name }}</h3>
                    <p class="text-sm text-gray-600 mb-2">{{ $business->city }}</p>
                    <div class="text-xs text-gray-500 mb-3">
                        @foreach($business->categories->take(2) as $category)
                            <span class="inline-block bg-gray-100 px-2 py-1 rounded mr-1">{{ $category->name }}</span>
                        @endforeach
                    </div>
                    <a href="{{ route('customer.bookings.create', ['business_id' => $business->id]) }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                        Book Now →
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500 text-sm">No businesses available at the moment.</p>
    @endif
</div>
@endsection

