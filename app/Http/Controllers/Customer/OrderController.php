<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'merchant_id' => 'required|exists:merchants,id',
            'delivery_date' => 'required|date|after_or_equal:tomorrow',
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
        ], [
            'delivery_date.after_or_equal' => 'Tanggal pengiriman tidak boleh di masa lalu atau hari ini.',
        ]);

        $user = $request->user();
        if (!$user->customer) {
            return response()->json(['message' => 'Silakan lengkapi profil Anda terlebih dahulu.'], 403);
        }

        try {
            DB::beginTransaction();

            $totalPrice = 0;
            $orderItemsData = [];

            // Calculate total and prepare items data
            foreach ($request->items as $item) {
                $menu = Menu::findOrFail($item['menu_id']);

                // Ensure menu belongs to the requested merchant
                if ($menu->merchant_id != $request->merchant_id) {
                    throw new \Exception("Menu tidak valid untuk merchant yang dipilih.");
                }

                $itemTotal = $menu->price * $item['quantity'];
                $totalPrice += $itemTotal;

                $orderItemsData[] = new OrderItem([
                    'menu_id' => $menu->id,
                    'quantity' => $item['quantity'],
                    'price_at_order' => $menu->price
                ]);
            }

            // Create the order
            $order = Order::create([
                'customer_id' => $user->customer->id,
                'merchant_id' => $request->merchant_id,
                'order_date' => now()->toDateString(),
                'delivery_date' => $request->delivery_date,
                'total_price' => $totalPrice,
                'status' => 'pending'
            ]);

            // Save all items associated with the order
            $order->orderItems()->saveMany($orderItemsData);

            // Generate Invoice
            $invoiceNumber = 'INV-' . now()->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(6));
            \App\Models\Invoice::create([
                'order_id' => $order->id,
                'invoice_number' => $invoiceNumber,
                'issue_date' => now(),
                'payment_status' => 'unpaid'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat!',
                'redirect' => route('customer.orders.index') // Changed to order history route
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membuat pesanan: ' . $e->getMessage()
            ], 500);
        }
    }
}
