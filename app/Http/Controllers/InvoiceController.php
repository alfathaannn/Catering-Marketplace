<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function show(Request $request, Invoice $invoice)
    {
        $invoice->load(['order.merchant', 'order.customer.user', 'order.orderItems.menu']);
        $order = $invoice->order;

        /** @var \App\Models\User $user */
        $user = $request->user();

        // Check Authorization
        $isCustomer = $user->customer && $user->customer->id === $order->customer_id;
        $isMerchant = $user->merchant && $user->merchant->id === $order->merchant_id;

        if (!$isCustomer && !$isMerchant) {
            abort(403, 'Unauthorized access to this invoice.');
        }

        return view('invoices.show', compact('invoice', 'order'));
    }
}
