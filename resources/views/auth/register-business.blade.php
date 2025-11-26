@extends('layouts.app')

@section('content')
<div class="w-6/12 mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-semibold mb-4">Create business account</h1>

    <form action="{{ url('/register/business') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="block text-sm mb-1" for="name">Contact name</label>
            <input id="name" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2" required>
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
            <label class="block text-sm mb-1" for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2" required>
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
            <label class="block text-sm mb-1" for="business_name">Business name</label>
            <input id="business_name" name="business_name" value="{{ old('business_name') }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-3">
            <label class="block text-sm mb-1" for="password">Password</label>
            <input id="password" name="password" type="password" class="w-full border rounded px-3 py-2" required>
            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm mb-1" for="password_confirmation">Confirm password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="w-full border rounded px-3 py-2" required>
        </div>

        <button class="bg-emerald-600 text-white px-4 py-2 rounded">Register business</button>
    </form>

    <p class="text-xs text-gray-500 mt-4">
        Just booking? <a class="text-indigo-500" href="{{ route('register.customer') }}">Register as customer</a>.
    </p>
</div>
@endsection
