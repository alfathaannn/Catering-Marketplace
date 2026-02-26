<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'menu_id',
        'quantity',
        'price_at_order'
    ];

    /**
     * Get the order that owns this item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the menu associated with this item.
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
