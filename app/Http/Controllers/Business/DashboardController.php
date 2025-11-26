<?php

namespace App\Http\Controllers\Business;

use Illuminate\Routing\Controller;
use App\Models\Business;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $business = Business::where('owner_id', Auth::id())->first();
        $todayBookings = 0;

        return view('business.dashboard', [
            'business'      => $business,
            'todayBookings' => $todayBookings,
        ]);
    }
}
