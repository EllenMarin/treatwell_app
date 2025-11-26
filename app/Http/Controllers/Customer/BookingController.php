<?php

namespace App\Http\Controllers\Customer;

use App\Models\Booking;
use App\Models\Business;
use App\Models\Plan;
use App\Mail\BookingConfirmation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of the customer's bookings.
     */
    public function index()
    {
        $bookings = Booking::where('customer_id', Auth::id())
            ->with(['business', 'plan', 'staff'])
            ->latest('booking_date')
            ->latest('booking_time')
            ->paginate(15);

        return view('customer.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create(Request $request)
    {
        $businesses = Business::active()->with('categories')->get();
        $selectedBusiness = null;
        $plans = collect();

        if ($request->has('business_id')) {
            $selectedBusiness = Business::with('plans.category')->findOrFail($request->business_id);
            $plans = $selectedBusiness->plans()->active()->get();
        }

        return view('customer.bookings.create', compact('businesses', 'selectedBusiness', 'plans'));
    }

    /**
     * Store a newly created booking in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'booking_time' => ['required', 'date_format:H:i'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $plan = Plan::with('business')->findOrFail($validated['plan_id']);
        
        // Check if business is active
        if (!$plan->business->is_active) {
            return back()->with('error', 'This business is not currently accepting bookings.');
        }

        // Check if plan is active
        if (!$plan->is_active) {
            return back()->with('error', 'This service is not currently available.');
        }

        $user = Auth::user();
        
        // Create booking datetime
        $bookingDateTime = Carbon::parse($validated['booking_date'] . ' ' . $validated['booking_time']);

        // Create the booking
        $booking = Booking::create([
            'business_id' => $plan->business_id,
            'customer_id' => $user->id,
            'plan_id' => $plan->id,
            'booking_date' => $validated['booking_date'],
            'booking_time' => $bookingDateTime,
            'duration' => $plan->duration,
            'status' => Booking::STATUS_PENDING,
            'price' => $plan->price,
            'currency' => $plan->currency,
            'deposit_paid' => false,
            'deposit_amount' => $plan->requires_deposit ? $plan->deposit_amount : null,
            'total_paid' => 0,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => $user->phone,
            'notes' => $validated['notes'] ?? null,
        ]);

        // Send confirmation email
        try {
            Mail::to($user->email)->send(new BookingConfirmation($booking));
            Mail::to($plan->business->email ?? $plan->business->owner->email)
                ->send(new BookingConfirmation($booking, true));
        } catch (\Exception $e) {
            // Log error but don't fail the booking
            \Log::error('Failed to send booking confirmation email: ' . $e->getMessage());
        }

        return redirect()->route('customer.bookings.index')
            ->with('status', 'Booking created successfully! You will receive a confirmation email shortly.');
    }

    /**
     * Cancel a booking.
     */
    public function cancel(Request $request, Booking $booking)
    {
        if ($booking->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$booking->canBeCancelled()) {
            return back()->with('error', 'This booking cannot be cancelled.');
        }

        $validated = $request->validate([
            'cancellation_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $booking->cancel($validated['cancellation_reason'] ?? 'Cancelled by customer');

        return back()->with('status', 'Booking cancelled successfully.');
    }
}

