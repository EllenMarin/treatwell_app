<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomerRegisterController;
use App\Http\Controllers\Auth\BusinessRegisterController;
use App\Http\Controllers\Business\DashboardController as BusinessDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/register/customer', [CustomerRegisterController::class, 'create'])->name('register.customer');
Route::post('/register/customer', [CustomerRegisterController::class, 'store']);

Route::get('/register/business', [BusinessRegisterController::class, 'create'])->name('register.business');
Route::post('/register/business', [BusinessRegisterController::class, 'store']);

Route::middleware(['auth', 'role:business'])->group(function () {
    Route::get('/business', [BusinessDashboardController::class, 'index'])->name('business.dashboard');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/businesses/{business}/approve', [AdminDashboardController::class, 'approve'])->name('admin.businesses.approve');
});
