@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Business Dashboard</h1>

@if($business && !$business->is_active)
    <div class="bg-yellow-100 border border-yellow-200 text-yellow-800 px-4 py-3 rounded mb-4">
        <strong>Pending Approval:</strong> Your business is awaiting admin approval before you can receive bookings.
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-2">Today's Bookings</h2>
        <p class="text-3xl font-bold">{{ $todayBookings ?? 0 }}</p>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-2">Services</h2>
        <p class="text-3xl font-bold">{{ $business->plans()->count() ?? 0 }}</p>
        <a href="{{ route('business.plans.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 mt-2 inline-block">
            Manage Services →
        </a>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-2">Business Status</h2>
        @if($business && $business->is_active)
            <span class="text-green-600 font-semibold">Approved</span>
        @else
            <span class="text-yellow-600 font-semibold">Pending Approval</span>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-3">Quick Actions</h2>
        <div class="space-y-2">
            <a href="{{ route('business.plans.index') }}" class="block text-indigo-600 hover:text-indigo-800">
                → Manage Services
            </a>
            <a href="{{ route('business.bookings.index') }}" class="block text-indigo-600 hover:text-indigo-800">
                → View All Bookings
            </a>
            <a href="{{ route('business.bookings.calendar') }}" class="block text-indigo-600 hover:text-indigo-800">
                → Calendar View
            </a>
        </div>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-semibold mb-3">Business Information</h2>
        <div class="text-sm space-y-1">
            <p><strong>Name:</strong> {{ $business->name ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $business->email ?? 'Not set' }}</p>
            <p><strong>Phone:</strong> {{ $business->phone ?? 'Not set' }}</p>
        </div>
    </div>
</div>
@endsection
