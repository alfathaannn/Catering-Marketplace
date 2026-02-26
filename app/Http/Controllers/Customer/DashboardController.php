<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Check if user has completed their customer profile
        if (!$user->customer) {
            return view('customer.complete-profile');
        }

        // Fetch all merchants with their active menus
        $merchants = \App\Models\Merchant::with(['menus' => function ($query) {
            $query->orderBy('name', 'asc');
        }])->latest()->get();

        return view('customer.dashboard', compact('merchants'));
    }

    public function storeProfile(Request $request)
    {
        $request->validate([
            'office_name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact' => 'required|string|max:20',
        ]);

        $user = $request->user();

        $user->customer()->create([
            'office_name' => $request->office_name,
            'address' => $request->address,
            'contact' => $request->contact,
        ]);

        return redirect()->route('customer.dashboard')->with('success', 'Profile completed successfully!');
    }
}
