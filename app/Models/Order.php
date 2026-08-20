<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'customer_name',
        'customer_email',
        'customer_address',
        'notes',
        'total_cents',
        'shipping_cents',
    ];

    // one order has many items
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
