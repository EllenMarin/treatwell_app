<?php

namespace App\Http\Controllers\Customer;

use App\Models\Booking;
use App\Models\Business;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the customer dashboard.
     */
    public function index()
    {
        $upcomingBookings = Booking::where('customer_id', Auth::id())
            ->upcoming()
            ->with(['business', 'plan'])
            ->limit(5)
            ->get();

        $recentBusinesses = Business::active()
            ->with('categories')
            ->latest()
            ->limit(6)
            ->get();

        return view('customer.dashboard', compact('upcomingBookings', 'recentBusinesses'));
    }
}

