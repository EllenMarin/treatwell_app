@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-semibold mb-6">Book an Appointment</h1>

    @if(session('error'))
        <div class="bg-red-100 border border-red-200 text-red-800 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Business Selection -->
        <div class="md:col-span-1">
            <div class="bg-white rounded shadow p-4">
                <h2 class="font-semibold mb-3">Select Business</h2>
                
                <form action="{{ route('customer.bookings.create') }}" method="GET">
                    <select name="business_id" onchange="this.form.submit()" class="w-full border rounded px-3 py-2">
                        <option value="">Choose a business...</option>
                        @foreach($businesses as $business)
                            <option value="{{ $business->id }}" {{ $selectedBusiness && $selectedBusiness->id == $business->id ? 'selected' : '' }}>
                                {{ $business->name }}
                            </option>
                        @endforeach
                    </select>
                </form>

                @if($selectedBusiness)
                    <div class="mt-4 pt-4 border-t">
                        <h3 class="font-semibold text-sm mb-2">{{ $selectedBusiness->name }}</h3>
                        @if($selectedBusiness->address)
                            <p class="text-xs text-gray-600 mb-1">
                                {{ $selectedBusiness->address }}<br>
                                {{ $selectedBusiness->city }} {{ $selectedBusiness->postal_code }}
                            </p>
                        @endif
                        @if($selectedBusiness->phone)
                            <p class="text-xs text-gray-600">Phone: {{ $selectedBusiness->phone }}</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Booking Form -->
        <div class="md:col-span-2">
            @if($selectedBusiness)
                <div class="bg-white rounded shadow p-6">
                    <h2 class="font-semibold mb-4">Select Service & Time</h2>

                    @if($plans->count() > 0)
                        <form action="{{ route('customer.bookings.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1" for="plan_id">Service *</label>
                                <select id="plan_id" name="plan_id" class="w-full border rounded px-3 py-2" required onchange="updateServiceDetails(this)">
                                    <option value="">Select a service...</option>
                                    @foreach($plans as $plan)
                                        <option value="{{ $plan->id }}" 
                                                data-price="{{ $plan->formatted_price }}" 
                                                data-duration="{{ $plan->formatted_duration }}"
                                                data-description="{{ $plan->description }}"
                                                {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                                            {{ $plan->name }} - {{ $plan->formatted_price }} ({{ $plan->formatted_duration }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('plan_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div id="service-details" class="mb-4 p-3 bg-gray-50 rounded" style="display: none;">
                                <p class="text-sm font-medium mb-1">Service Details:</p>
                                <p id="service-description" class="text-sm text-gray-600 mb-2"></p>
                                <p class="text-sm"><strong>Duration:</strong> <span id="service-duration"></span></p>
                                <p class="text-sm"><strong>Price:</strong> <span id="service-price"></span></p>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="booking_date">Date *</label>
                                    <input id="booking_date" name="booking_date" type="date" 
                                           min="{{ date('Y-m-d') }}" 
                                           value="{{ old('booking_date') }}" 
                                           class="w-full border rounded px-3 py-2" required>
                                    @error('booking_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-1" for="booking_time">Time *</label>
                                    <select id="booking_time" name="booking_time" class="w-full border rounded px-3 py-2" required>
                                        <option value="">Select time...</option>
                                        @for($hour = 9; $hour <= 18; $hour++)
                                            @foreach(['00', '30'] as $minute)
                                                @php
                                                    $time = sprintf('%02d:%s', $hour, $minute);
                                                    $displayTime = date('g:i A', strtotime($time));
                                                @endphp
                                                <option value="{{ $time }}" {{ old('booking_time') == $time ? 'selected' : '' }}>
                                                    {{ $displayTime }}
                                                </option>
                                            @endforeach
                                        @endfor
                                    </select>
                                    @error('booking_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1" for="notes">Special Requests (Optional)</label>
                                <textarea id="notes" name="notes" rows="3" class="w-full border rounded px-3 py-2" placeholder="Any special requests or notes for the business...">{{ old('notes') }}</textarea>
                                @error('notes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="flex space-x-3">
                                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                                    Book Appointment
                                </button>
                                <a href="{{ route('customer.dashboard') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    @else
                        <p class="text-gray-500">This business has no services available at the moment.</p>
                    @endif
                </div>
            @else
                <div class="bg-white rounded shadow p-6">
                    <p class="text-gray-500 text-center">Please select a business to view available services.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function updateServiceDetails(select) {
    const option = select.options[select.selectedIndex];
    const detailsDiv = document.getElementById('service-details');
    
    if (option.value) {
        document.getElementById('service-description').textContent = option.dataset.description || 'No description available';
        document.getElementById('service-duration').textContent = option.dataset.duration;
        document.getElementById('service-price').textContent = option.dataset.price;
        detailsDiv.style.display = 'block';
    } else {
        detailsDiv.style.display = 'none';
    }
}
</script>
@endsection

