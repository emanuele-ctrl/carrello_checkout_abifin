<?php

namespace App\Services;

use App\Models\Product;

class CartCalculator
{
    private const THRESHOLD_FREE_SHIPPING_CENTS = 5000; // 50.00 minimum order amount for free shipping in cents

    private const SHIPPING_COST_CENTS = 690; // 6.90 shipping cost in cents

    /**
     * @param  array<int, array{product: Product, quantity: int}>  $items
     * @return array{subtotal_cents: int, shipping_cents: int, total_cents: int}
     */
    public function calculate(array $items): array
    {
        $subtotal_cents = 0;

        // scan each item in the cart and calculate the subtotal
        foreach ($items as $item) {
            $subtotal_cents += $item['product']->price_cents * $item['quantity'];
        }

        // checks for free shipping threshold and calculates shipping cost
        $shipping = $subtotal_cents >= self::THRESHOLD_FREE_SHIPPING_CENTS ? 0 : self::SHIPPING_COST_CENTS;

        // retuns array like: subtotal, shipping cost, total
        return ['subtotal_cents' => $subtotal_cents, 'shipping_cents' => $shipping, 'total_cents' => $subtotal_cents + $shipping];
    }
}
