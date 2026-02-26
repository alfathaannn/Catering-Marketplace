<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'merchant_id',
        'order_date',
        'delivery_date',
        'total_price',
        'status',
    ];

    /**
     * Get the customer that made the order.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the merchant that receives the order.
     */
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    /**
     * Get the items for the order.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the invoice for the order.
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
