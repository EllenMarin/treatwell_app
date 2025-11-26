@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-semibold mb-6">Edit Service</h1>

    <div class="bg-white rounded shadow p-6">
        <form action="{{ route('business.plans.update', $plan) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1" for="name">Service Name *</label>
                <input id="name" name="name" type="text" value="{{ old('name', $plan->name) }}" class="w-full border rounded px-3 py-2" required>
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1" for="category_id">Category *</label>
                <select id="category_id" name="category_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $plan->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1" for="description">Description</label>
                <textarea id="description" name="description" rows="3" class="w-full border rounded px-3 py-2">{{ old('description', $plan->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1" for="duration">Duration (minutes) *</label>
                    <input id="duration" name="duration" type="number" min="15" max="480" value="{{ old('duration', $plan->duration) }}" class="w-full border rounded px-3 py-2" required>
                    @error('duration') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1" for="max_bookings_per_day">Max Bookings/Day</label>
                    <input id="max_bookings_per_day" name="max_bookings_per_day" type="number" min="1" value="{{ old('max_bookings_per_day', $plan->max_bookings_per_day) }}" class="w-full border rounded px-3 py-2">
                    @error('max_bookings_per_day') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1" for="price">Price *</label>
                    <input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price', $plan->price) }}" class="w-full border rounded px-3 py-2" required>
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1" for="currency">Currency *</label>
                    <select id="currency" name="currency" class="w-full border rounded px-3 py-2" required>
                        <option value="GBP" {{ old('currency', $plan->currency) == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                        <option value="USD" {{ old('currency', $plan->currency) == 'USD' ? 'selected' : '' }}>USD ($)</option>
                        <option value="EUR" {{ old('currency', $plan->currency) == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                    </select>
                    @error('currency') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="requires_deposit" value="1" {{ old('requires_deposit', $plan->requires_deposit) ? 'checked' : '' }} class="mr-2" onchange="toggleDepositAmount(this)">
                    <span class="text-sm font-medium">Requires Deposit</span>
                </label>
            </div>

            <div class="mb-4" id="deposit_amount_field" style="display: {{ old('requires_deposit', $plan->requires_deposit) ? 'block' : 'none' }};">
                <label class="block text-sm font-medium mb-1" for="deposit_amount">Deposit Amount</label>
                <input id="deposit_amount" name="deposit_amount" type="number" step="0.01" min="0" value="{{ old('deposit_amount', $plan->deposit_amount) }}" class="w-full border rounded px-3 py-2">
                @error('deposit_amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $plan->is_active) ? 'checked' : '' }} class="mr-2">
                    <span class="text-sm font-medium">Active (visible to customers)</span>
                </label>
            </div>

            <div class="flex space-x-3">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    Update Service
                </button>
                <a href="{{ route('business.plans.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function toggleDepositAmount(checkbox) {
    const field = document.getElementById('deposit_amount_field');
    field.style.display = checkbox.checked ? 'block' : 'none';
}
</script>
@endsection

