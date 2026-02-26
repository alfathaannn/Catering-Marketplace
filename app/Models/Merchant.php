<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'company_name',
        'address',
        'contact',
        'description',
    ];

    /**
     * Get the user that owns the merchant profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the menus associated with the merchant.
     */
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
