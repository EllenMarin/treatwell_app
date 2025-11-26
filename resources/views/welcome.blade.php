@extends('layouts.app')

@section('title', 'Welcome to Agendea')

@section('content')
<!-- Hero Section -->
<div class="gradient-hero text-white">
    <div class="w-9/12 mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-6 animate-fade-in">
                Book Your Perfect
                <span class="block mt-2">Beauty & Wellness Experience</span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-primary-100 max-w-3xl mx-auto">
                Connect with top-rated professionals in your area. Easy booking, instant confirmation, and exceptional service.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register.customer') }}" class="btn btn-lg bg-white text-primary-700 hover:bg-gray-100 shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Book an Appointment
                </a>
                <a href="{{ route('register.business') }}" class="btn btn-lg bg-transparent border-2 border-white text-white hover:bg-white hover:text-primary-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    List Your Business
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Why Choose Agendea?</h2>
            <p class="text-xl text-gray-600">Everything you need for seamless appointment booking</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="card hover:shadow-xl transition-shadow duration-300">
                <div class="card-body text-center">
                    <div class="w-16 h-16 gradient-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">24/7 Booking</h3>
                    <p class="text-gray-600">Book appointments anytime, anywhere. No phone calls needed.</p>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="card hover:shadow-xl transition-shadow duration-300">
                <div class="card-body text-center">
                    <div class="w-16 h-16 gradient-secondary rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Instant Confirmation</h3>
                    <p class="text-gray-600">Get immediate booking confirmation via email and SMS.</p>
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="card hover:shadow-xl transition-shadow duration-300">
                <div class="card-body text-center">
                    <div class="w-16 h-16 gradient-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Top Professionals</h3>
                    <p class="text-gray-600">Access verified, highly-rated beauty and wellness experts.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- How It Works Section -->
<div class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">How It Works</h2>
            <p class="text-xl text-gray-600">Book your appointment in three simple steps</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <!-- Step 1 -->
            <div class="text-center">
                <div class="relative">
                    <div class="w-20 h-20 bg-primary-600 text-white rounded-full flex items-center justify-center mx-auto mb-6 text-3xl font-bold shadow-lg">
                        1
                    </div>
{{--                    @if(!$loop->last ?? true)--}}
{{--                        <div class="hidden md:block absolute top-10 left-1/2 w-full h-0.5 bg-primary-200"></div>--}}
{{--                    @endif--}}
                </div>
                <h3 class="text-xl font-semibold mb-3">Browse Services</h3>
                <p class="text-gray-600">Explore a wide range of beauty and wellness services in your area.</p>
            </div>

            <!-- Step 2 -->
            <div class="text-center">
                <div class="relative">
                    <div class="w-20 h-20 bg-secondary-600 text-white rounded-full flex items-center justify-center mx-auto mb-6 text-3xl font-bold shadow-lg">
                        2
                    </div>
{{--                    @if(!$loop->last ?? true)--}}
{{--                        <div class="hidden md:block absolute top-10 left-1/2 w-full h-0.5 bg-secondary-200"></div>--}}
{{--                    @endif--}}
                </div>
                <h3 class="text-xl font-semibold mb-3">Choose & Book</h3>
                <p class="text-gray-600">Select your preferred time slot and book instantly online.</p>
            </div>

            <!-- Step 3 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-success-600 text-white rounded-full flex items-center justify-center mx-auto mb-6 text-3xl font-bold shadow-lg">
                    3
                </div>
                <h3 class="text-xl font-semibold mb-3">Enjoy Your Visit</h3>
                <p class="text-gray-600">Receive confirmation and enjoy your premium service experience.</p>
            </div>
        </div>
    </div>
</div>

<!-- Popular Categories -->
<div class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Popular Categories</h2>
            <p class="text-xl text-gray-600">Discover the services you love</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="card hover:shadow-xl transition-all duration-300 cursor-pointer group">
                <div class="card-body text-center">
                    <div class="text-4xl mb-3">💇</div>
                    <h3 class="font-semibold group-hover:text-primary-600 transition-colors">Hair Salon</h3>
                </div>
            </div>

            <div class="card hover:shadow-xl transition-all duration-300 cursor-pointer group">
                <div class="card-body text-center">
                    <div class="text-4xl mb-3">💅</div>
                    <h3 class="font-semibold group-hover:text-primary-600 transition-colors">Nail Care</h3>
                </div>
            </div>

            <div class="card hover:shadow-xl transition-all duration-300 cursor-pointer group">
                <div class="card-body text-center">
                    <div class="text-4xl mb-3">💆</div>
                    <h3 class="font-semibold group-hover:text-primary-600 transition-colors">Spa & Massage</h3>
                </div>
            </div>

            <div class="card hover:shadow-xl transition-all duration-300 cursor-pointer group">
                <div class="card-body text-center">
                    <div class="text-4xl mb-3">✨</div>
                    <h3 class="font-semibold group-hover:text-primary-600 transition-colors">Beauty</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="gradient-hero text-white py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-bold mb-6">Ready to Get Started?</h2>
        <p class="text-xl mb-8 text-primary-100">Join thousands of satisfied customers and businesses on Agendea</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register.customer') }}" class="btn btn-lg bg-white text-primary-700 hover:bg-gray-100 shadow-xl">
                Sign Up as Customer
            </a>
            <a href="{{ route('register.business') }}" class="btn btn-lg bg-transparent border-2 border-white text-white hover:bg-white hover:text-primary-700">
                Register Your Business
            </a>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold text-primary-600 mb-2">10K+</div>
                <div class="text-gray-600">Happy Customers</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-secondary-600 mb-2">500+</div>
                <div class="text-gray-600">Partner Businesses</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-success-600 mb-2">50K+</div>
                <div class="text-gray-600">Bookings Made</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-warning-600 mb-2">4.9★</div>
                <div class="text-gray-600">Average Rating</div>
            </div>
        </div>
    </div>
</div>
@endsection

