<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the merchant dashboard or profile completion step if incomplete.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Check if the merchant has completed their profile
        if (!$user->merchant) {
            return view('merchant.complete-profile');
        }

        return view('merchant.dashboard', compact('user'));
    }

    /**
     * Store the merchant profile data.
     */
    public function storeProfile(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'address' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $user = $request->user();

        $user->merchant()->create([
            'company_name' => $request->company_name,
            'contact' => $request->contact,
            'address' => $request->address,
            'description' => $request->description,
        ]);

        return redirect()->route('merchant.dashboard')->with('success', 'Profile completed successfully!');
    }
}
