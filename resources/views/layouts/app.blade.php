<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Agendea') }} - @yield('title', 'Book Beauty & Wellness Appointments')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|poppins:600,700" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo and Brand -->
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center space-x-2">
                            <div class="w-10 h-10 gradient-hero rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <span class="text-2xl font-bold text-gradient">Agendea</span>
                        </a>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex md:items-center md:space-x-4">
                        @guest
                            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'nav-link-active' : '' }}">
                                Home
                            </a>
                            <a href="#" class="nav-link">Browse Services</a>
                            <a href="#" class="nav-link">How It Works</a>
                            <a href="{{ route('login') }}" class="nav-link">Sign In</a>
                            <a href="{{ route('register.customer') }}" class="btn btn-primary btn-sm">Get Started</a>
                        @else
                            @if(auth()->user()->hasRole('customer'))
                                <a href="{{ route('customer.dashboard') }}" class="nav-link {{ request()->routeIs('customer.dashboard') ? 'nav-link-active' : '' }}">
                                    Dashboard
                                </a>
                                <a href="{{ route('customer.bookings.index') }}" class="nav-link {{ request()->routeIs('customer.bookings.*') ? 'nav-link-active' : '' }}">
                                    My Bookings
                                </a>
                                <a href="{{ route('customer.bookings.create') }}" class="btn btn-primary btn-sm">
                                    Book Appointment
                                </a>
                            @elseif(auth()->user()->hasRole('business'))
                                <a href="{{ route('business.dashboard') }}" class="nav-link {{ request()->routeIs('business.dashboard') ? 'nav-link-active' : '' }}">
                                    Dashboard
                                </a>
                                <a href="{{ route('business.plans.index') }}" class="nav-link {{ request()->routeIs('business.plans.*') ? 'nav-link-active' : '' }}">
                                    Services
                                </a>
                                <a href="{{ route('business.bookings.index') }}" class="nav-link {{ request()->routeIs('business.bookings.*') ? 'nav-link-active' : '' }}">
                                    Bookings
                                </a>
                            @elseif(auth()->user()->hasRole('admin'))
                                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.*') ? 'nav-link-active' : '' }}">
                                    Admin Dashboard
                                </a>
                            @endif

                            <!-- User Dropdown -->
                            <div class="relative ml-3">
                                <button id="user-menu-button" type="button" class="flex items-center space-x-2 text-gray-700 hover:text-primary-600 focus:outline-none">
                                    <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                                        <span class="text-primary-700 font-semibold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                    <span class="font-medium">{{ auth()->user()->name }}</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 border border-gray-200">
                                    <div class="px-4 py-2 border-b border-gray-200">
                                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                    </div>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile Settings</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-danger-600 hover:bg-danger-50">
                                            Sign Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center md:hidden">
                        <button id="mobile-menu-button" type="button" class="text-gray-700 hover:text-primary-600 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    @guest
                        <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">Home</a>
                        <a href="#" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">Browse Services</a>
                        <a href="#" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">How It Works</a>
                        <a href="{{ route('login') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">Sign In</a>
                        <a href="{{ route('register.customer') }}" class="block px-3 py-2 rounded-lg bg-primary-600 text-white">Get Started</a>
                    @else
                        @if(auth()->user()->hasRole('customer'))
                            <a href="{{ route('customer.dashboard') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">Dashboard</a>
                            <a href="{{ route('customer.bookings.index') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">My Bookings</a>
                            <a href="{{ route('customer.bookings.create') }}" class="block px-3 py-2 rounded-lg bg-primary-600 text-white">Book Appointment</a>
                        @elseif(auth()->user()->hasRole('business'))
                            <a href="{{ route('business.dashboard') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">Dashboard</a>
                            <a href="{{ route('business.plans.index') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">Services</a>
                            <a href="{{ route('business.bookings.index') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-50">Bookings</a>
                        @endif
                        <div class="border-t border-gray-200 pt-2 mt-2">
                            <div class="px-3 py-2">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-3 py-2 text-danger-600 hover:bg-danger-50 rounded-lg">
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    @endguest
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-1">
            @if(session('status'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="alert alert-success animate-slide-down">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ session('status') }}
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="alert alert-error animate-slide-down">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            {{ session('error') }}
                        </div>
                    </div>
                </div>
            @endif

            <div class="py-6">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-gray-300 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="w-10 h-10 gradient-hero rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <span class="text-2xl font-bold text-white">Agendea</span>
                        </div>
                        <p class="text-gray-400 mb-4">Your trusted platform for booking beauty and wellness appointments. Connect with top-rated professionals in your area.</p>
                    </div>

                    <div>
                        <h3 class="text-white font-semibold mb-4">For Customers</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="hover:text-white transition-colors">Browse Services</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">How It Works</a></li>
                            <li><a href="{{ route('register.customer') }}" class="hover:text-white transition-colors">Sign Up</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-white font-semibold mb-4">For Businesses</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('register.business') }}" class="hover:text-white transition-colors">List Your Business</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Pricing</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Resources</a></li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400 text-sm">
                    <p>&copy; {{ date('Y') }} Agendea. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
