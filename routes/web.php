<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomerRegisterController;
use App\Http\Controllers\Auth\BusinessRegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Business\DashboardController as BusinessDashboardController;
use App\Http\Controllers\Business\PlanController;
use App\Http\Controllers\Business\BookingController as BusinessBookingController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\BookingController as CustomerBookingController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;

// Home
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('business')) {
            return redirect()->route('business.dashboard');
        } else {
            return redirect()->route('customer.dashboard');
        }
    }
    return view('welcome');
})->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);

    Route::get('/register/customer', [CustomerRegisterController::class, 'create'])->name('register.customer');
    Route::post('/register/customer', [CustomerRegisterController::class, 'store']);

    Route::get('/register/business', [BusinessRegisterController::class, 'create'])->name('register.business');
    Route::post('/register/business', [BusinessRegisterController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

// Business Routes
Route::middleware(['auth', 'role:business'])->prefix('business')->name('business.')->group(function () {
    Route::get('/', [BusinessDashboardController::class, 'index'])->name('dashboard');

    // Service/Plan Management
    Route::resource('plans', PlanController::class);

    // Booking Management
    Route::get('/bookings', [BusinessBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/calendar', [BusinessBookingController::class, 'calendar'])->name('bookings.calendar');
    Route::post('/bookings/{booking}/confirm', [BusinessBookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('/bookings/{booking}/complete', [BusinessBookingController::class, 'complete'])->name('bookings.complete');
    Route::post('/bookings/{booking}/cancel', [BusinessBookingController::class, 'cancel'])->name('bookings.cancel');
});

// Customer Routes
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/', [CustomerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/bookings', [CustomerBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [CustomerBookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [CustomerBookingController::class, 'store'])->name('bookings.store');
    Route::post('/bookings/{booking}/cancel', [CustomerBookingController::class, 'cancel'])->name('bookings.cancel');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/businesses/{business}/approve', [AdminDashboardController::class, 'approve'])->name('businesses.approve');
});
