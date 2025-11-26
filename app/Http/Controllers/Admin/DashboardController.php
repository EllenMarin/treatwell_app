<?php

namespace App\Http\Controllers\Admin;

use App\Models\Business;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $businesses = Business::with('owner')->latest()->get();

        return view('admin.dashboard', compact('businesses'));
    }

    public function approve(Business $business)
    {
        $business->update(['is_active' => true]);

        return back()->with('status', 'Business approved.');
    }
}
