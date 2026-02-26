<?php

namespace App\Http\Controllers\Merchant;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $merchant = $request->user()->merchant;

        if (!$merchant) {
            return redirect()->route('merchant.dashboard')->with('error', 'Silakan lengkapi profil merchant Anda terlebih dahulu.');
        }

        $orders = Order::with(['customer.user', 'orderItems.menu', 'invoice'])
            ->where('merchant_id', $merchant->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('merchant.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $merchant = $request->user()->merchant;

        if (!$merchant || $order->merchant_id !== $merchant->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:confirmed,delivered,cancelled'
        ]);

        $order->status = $request->status;
        $order->save();

        if (in_array($request->status, ['confirmed', 'delivered']) && $order->invoice) {
            $order->invoice->update(['payment_status' => 'paid']);
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
