<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use App\Models\Business;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BusinessRegisterController extends Controller
{
    public function create()
    {
        return view('auth.register-business');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'      => ['required', 'confirmed', 'min:8'],
            'business_name' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $businessRole = Role::where('name', 'business')->first();
        if ($businessRole) {
            $user->roles()->attach($businessRole);
        }

        $businessName = $validated['business_name'] ?: ($validated['name'] . "'s business");

        Business::create([
            'owner_id'  => $user->id,
            'name'      => $businessName,
            'slug'      => Str::slug($businessName . '-' . $user->id),
            'is_active' => false,
        ]);

        Auth::login($user);

        return redirect()->route('business.dashboard')->with('status', 'Business created, pending admin approval.');
    }
}
