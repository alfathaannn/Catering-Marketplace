<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'merchant_id',
        'name',
        'description',
        'price',
        'image',
    ];

    /**
     * Get the merchant that owns the menu.
     */
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
