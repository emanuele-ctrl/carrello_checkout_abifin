<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    // Definisce dati fittizi di default per un Product, usati nei test
    // (es. Product::factory()->create(['stock' => 10]) sovrascrive solo 'stock',
    // il resto viene generato automaticamente da qui)
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true), // 3 parole casuali unite, es. "Zaino da montagna"
            'description' => fake()->sentence(),
            'price_cents' => fake()->numberBetween(500, 9999), // tra 5€ e 99,99€
            'stock' => fake()->numberBetween(0, 50),
        ];
    }
}
