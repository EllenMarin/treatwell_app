@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
<div class="w-9/12 mx-auto px-4 sm:px-6 lg:px-8">
    <div class="min-h-[80vh] flex items-center justify-center">
        <div class="w-full">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 gradient-hero rounded-xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome Back!</h1>
                <p class="text-gray-600">Sign in to your Agendea account</p>
            </div>

            <!-- Login Card -->
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('login') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Email Field -->
                        <div class="form-group">
                            <label class="label" for="email">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                                Email Address
                            </label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                class="input @error('email') input-error @enderror"
                                placeholder="you@example.com"
                                required
                                autofocus
                            >
                            @error('email')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="form-group">
                            <label class="label" for="password">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Password
                            </label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="input @error('password') input-error @enderror"
                                placeholder="••••••••"
                                required
                            >
                            @error('password')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="remember" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                                <span class="ml-2 text-sm text-gray-700">Remember me</span>
                            </label>
                            <a href="#" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                                Forgot password?
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-full btn-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Sign In
                        </button>
                    </form>
                </div>

                <!-- Footer -->
                <div class="card-footer text-center">
                    <p class="text-sm text-gray-600 mb-3">Don't have an account?</p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('register.customer') }}" class="btn btn-outline flex-1">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Sign Up as Customer
                        </a>
                        <a href="{{ route('register.business') }}" class="btn btn-outline flex-1">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Register Business
                        </a>
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <p class="text-center text-sm text-gray-500 mt-6">
                By signing in, you agree to our
                <a href="#" class="text-primary-600 hover:text-primary-700">Terms of Service</a>
                and
                <a href="#" class="text-primary-600 hover:text-primary-700">Privacy Policy</a>
            </p>
        </div>
    </div>
</div>
@endsection

