<?php

namespace App\Http\Controllers\Business;

use App\Models\Business;
use App\Models\Category;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PlanController extends Controller
{
    /**
     * Display a listing of the plans.
     */
    public function index()
    {
        $business = Business::where('owner_id', Auth::id())->firstOrFail();
        $plans = $business->plans()->with('category')->latest()->get();

        return view('business.plans.index', compact('business', 'plans'));
    }

    /**
     * Show the form for creating a new plan.
     */
    public function create()
    {
        $business = Business::where('owner_id', Auth::id())->firstOrFail();
        $categories = Category::where('is_active', true)->get();

        return view('business.plans.create', compact('business', 'categories'));
    }

    /**
     * Store a newly created plan in storage.
     */
    public function store(Request $request)
    {
        $business = Business::where('owner_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'duration' => ['required', 'integer', 'min:15', 'max:480'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:3'],
            'is_active' => ['boolean'],
            'max_bookings_per_day' => ['nullable', 'integer', 'min:1'],
            'requires_deposit' => ['boolean'],
            'deposit_amount' => ['nullable', 'numeric', 'min:0'],
        ]);

        $validated['business_id'] = $business->id;
        $validated['slug'] = Str::slug($validated['name'] . '-' . $business->id);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['requires_deposit'] = $request->boolean('requires_deposit', false);

        Plan::create($validated);

        return redirect()->route('business.plans.index')
            ->with('status', 'Service created successfully!');
    }

    /**
     * Display the specified plan.
     */
    public function show(Plan $plan)
    {
        $business = Business::where('owner_id', Auth::id())->firstOrFail();
        
        if ($plan->business_id !== $business->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('business.plans.show', compact('plan', 'business'));
    }

    /**
     * Show the form for editing the specified plan.
     */
    public function edit(Plan $plan)
    {
        $business = Business::where('owner_id', Auth::id())->firstOrFail();
        
        if ($plan->business_id !== $business->id) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::where('is_active', true)->get();

        return view('business.plans.edit', compact('plan', 'business', 'categories'));
    }

    /**
     * Update the specified plan in storage.
     */
    public function update(Request $request, Plan $plan)
    {
        $business = Business::where('owner_id', Auth::id())->firstOrFail();
        
        if ($plan->business_id !== $business->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'duration' => ['required', 'integer', 'min:15', 'max:480'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:3'],
            'is_active' => ['boolean'],
            'max_bookings_per_day' => ['nullable', 'integer', 'min:1'],
            'requires_deposit' => ['boolean'],
            'deposit_amount' => ['nullable', 'numeric', 'min:0'],
        ]);

        $validated['slug'] = Str::slug($validated['name'] . '-' . $business->id);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['requires_deposit'] = $request->boolean('requires_deposit', false);

        $plan->update($validated);

        return redirect()->route('business.plans.index')
            ->with('status', 'Service updated successfully!');
    }

    /**
     * Remove the specified plan from storage.
     */
    public function destroy(Plan $plan)
    {
        $business = Business::where('owner_id', Auth::id())->firstOrFail();
        
        if ($plan->business_id !== $business->id) {
            abort(403, 'Unauthorized action.');
        }

        // Check if plan has any bookings
        if ($plan->bookings()->count() > 0) {
            return back()->with('error', 'Cannot delete service with existing bookings. Please deactivate it instead.');
        }

        $plan->delete();

        return redirect()->route('business.plans.index')
            ->with('status', 'Service deleted successfully!');
    }
}

