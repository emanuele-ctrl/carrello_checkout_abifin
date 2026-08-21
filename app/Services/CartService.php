<?php

namespace App\Services;

use App\Models\Product;

class CartService
{
    private const SESSION_KEY = 'cart';

    /**
     * @return array<int, array{product: Product, quantity: int}>
     */
    public function getItems(): array
    {
        // associative array
        $cart = session(self::SESSION_KEY, []);
        $items = [];

        // scan each item in the cart and retrieve the product from the database
        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);

            if ($product) {
                $items[] = ['product' => $product, 'quantity' => $quantity];
            }
        }

        return $items;
    }

    // add an item to the cart, if the item already exists, increase the quantity
    public function add(int $productId, int $quantity): void
    {
        // check if the product exists in the database and if it fails it runs the error: ModelNotFoundException
        $product = Product::findOrFail($productId);
        $cart = session(self::SESSION_KEY, []);

        $current = $cart[$productId] ?? 0;
        // check if the quantity plus the current quantity is less than the stock, if it is greater than the stock, set the quantity to the stock
        $new = min($current + $quantity, $product->stock);
        // check if the new quantity is less than 1, if it is less than 1, set the quantity to 1
        $new = max($new, 1);

        // add the product to the cart with the new quantity and save it in the session
        $cart[$productId] = $new;
        session([self::SESSION_KEY => $cart]);
    }

    // like add but it updates the quantity instead of adding it to the current quantity
    public function updateQuantity(int $productId, int $quantity): void
    {
        $product = Product::findOrFail($productId);
        $cart = session(self::SESSION_KEY, []);

        $quantity = max(1, min($quantity, $product->stock));
        $cart[$productId] = $quantity;

        session([self::SESSION_KEY => $cart]);
    }

    // it removes the product from the cart and saves the new cart in the session
    public function remove(int $productId): void
    {
        $cart = session(self::SESSION_KEY, []);
        unset($cart[$productId]);
        session([self::SESSION_KEY => $cart]);
    }

    // it clears the cart by removing the session key
    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    // it count the items in the cart
    public function countItems(): int
    {
        return array_sum(session(self::SESSION_KEY, []));
    }
}
