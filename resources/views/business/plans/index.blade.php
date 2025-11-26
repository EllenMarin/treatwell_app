@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-semibold">Manage Services</h1>
    <a href="{{ route('business.plans.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
        Add New Service
    </a>
</div>

@if(session('error'))
    <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-2 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

<div class="bg-white rounded shadow overflow-hidden">
    @if($plans->count() > 0)
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="text-left p-3 font-semibold">Service Name</th>
                    <th class="text-left p-3 font-semibold">Category</th>
                    <th class="text-left p-3 font-semibold">Duration</th>
                    <th class="text-left p-3 font-semibold">Price</th>
                    <th class="text-left p-3 font-semibold">Status</th>
                    <th class="text-left p-3 font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($plans as $plan)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">
                            <div class="font-medium">{{ $plan->name }}</div>
                            @if($plan->description)
                                <div class="text-xs text-gray-500 mt-1">{{ Str::limit($plan->description, 50) }}</div>
                            @endif
                        </td>
                        <td class="p-3">{{ $plan->category->name ?? 'N/A' }}</td>
                        <td class="p-3">{{ $plan->formatted_duration }}</td>
                        <td class="p-3">{{ $plan->formatted_price }}</td>
                        <td class="p-3">
                            @if($plan->is_active)
                                <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Active</span>
                            @else
                                <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">Inactive</span>
                            @endif
                        </td>
                        <td class="p-3">
                            <div class="flex space-x-2">
                                <a href="{{ route('business.plans.edit', $plan) }}" class="text-indigo-600 hover:text-indigo-800">
                                    Edit
                                </a>
                                <form action="{{ route('business.plans.destroy', $plan) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="p-8 text-center text-gray-500">
            <p class="mb-4">You haven't created any services yet.</p>
            <a href="{{ route('business.plans.create') }}" class="text-indigo-600 hover:text-indigo-800">
                Create your first service
            </a>
        </div>
    @endif
</div>

<div class="mt-4">
    <a href="{{ route('business.dashboard') }}" class="text-sm text-gray-600 hover:text-gray-800">
        ← Back to Dashboard
    </a>
</div>
@endsection

