<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;

class OrderHistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user->customer) {
            return redirect()->route('customer.dashboard')->with('error', 'Silakan lengkapi profil Anda terlebih dahulu.');
        }

        $orders = Order::with(['merchant', 'orderItems.menu'])
            ->where('customer_id', $user->customer->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.orders', compact('orders'));
    }
}
