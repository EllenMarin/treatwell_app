@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Admin panel</h1>

<div class="bg-white rounded shadow">
    <table class="min-w-full text-sm">
        <thead class="border-b">
            <tr>
                <th class="text-left p-3">Business</th>
                <th class="text-left p-3">Owner</th>
                <th class="text-left p-3">Status</th>
                <th class="text-left p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($businesses as $business)
                <tr class="border-b">
                    <td class="p-3">{{ $business->name }}</td>
                    <td class="p-3">{{ $business->owner->name }} ({{ $business->owner->email }})</td>
                    <td class="p-3">
                        @if($business->is_active)
                            <span class="text-green-600">Active</span>
                        @else
                            <span class="text-yellow-600">Pending</span>
                        @endif
                    </td>
                    <td class="p-3">
                        @if(!$business->is_active)
                            <form action="{{ route('admin.businesses.approve', $business) }}" method="POST" class="inline">
                                @csrf
                                <button class="text-indigo-600 text-sm" type="submit">Approve</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td class="p-3" colspan="4">No businesses yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
