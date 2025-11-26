<?php

namespace App\Http\Controllers\Business;

use App\Models\Booking;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of bookings.
     */
    public function index(Request $request)
    {
        $business = Business::where('owner_id', Auth::id())->firstOrFail();
        
        $query = Booking::where('business_id', $business->id)
            ->with(['customer', 'plan', 'staff']);

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->has('date')) {
            $query->forDate($request->date);
        }

        $bookings = $query->latest('booking_date')
            ->latest('booking_time')
            ->paginate(20);

        $statusCounts = [
            'all' => Booking::where('business_id', $business->id)->count(),
            'pending' => Booking::where('business_id', $business->id)->pending()->count(),
            'confirmed' => Booking::where('business_id', $business->id)->confirmed()->count(),
            'completed' => Booking::where('business_id', $business->id)->completed()->count(),
        ];

        return view('business.bookings.index', compact('business', 'bookings', 'statusCounts'));
    }

    /**
     * Display calendar view of bookings.
     */
    public function calendar(Request $request)
    {
        $business = Business::where('owner_id', Auth::id())->firstOrFail();
        
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);
        
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        $bookings = Booking::where('business_id', $business->id)
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->with(['customer', 'plan'])
            ->get()
            ->groupBy(function($booking) {
                return $booking->booking_date->format('Y-m-d');
            });

        return view('business.bookings.calendar', compact('business', 'bookings', 'startDate', 'endDate'));
    }

    /**
     * Confirm a booking.
     */
    public function confirm(Booking $booking)
    {
        $business = Business::where('owner_id', Auth::id())->firstOrFail();
        
        if ($booking->business_id !== $business->id) {
            abort(403, 'Unauthorized action.');
        }

        $booking->confirm();

        return back()->with('status', 'Booking confirmed successfully.');
    }

    /**
     * Complete a booking.
     */
    public function complete(Booking $booking)
    {
        $business = Business::where('owner_id', Auth::id())->firstOrFail();
        
        if ($booking->business_id !== $business->id) {
            abort(403, 'Unauthorized action.');
        }

        $booking->complete();

        return back()->with('status', 'Booking marked as completed.');
    }

    /**
     * Cancel a booking.
     */
    public function cancel(Request $request, Booking $booking)
    {
        $business = Business::where('owner_id', Auth::id())->firstOrFail();
        
        if ($booking->business_id !== $business->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'cancellation_reason' => ['required', 'string', 'max:500'],
        ]);

        $booking->cancel($validated['cancellation_reason']);

        return back()->with('status', 'Booking cancelled.');
    }
}

