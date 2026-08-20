<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price_cents',
        'stock',
    ];

    // usefull if in the future we want to see what order have bought this product
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // it return the price in euros instead of cents
    public function getPriceAttribute(): float
    {
        return $this->price_cents / 100;
    }
}
