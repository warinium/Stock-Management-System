<?php

namespace Database\Factories\Models;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->sentences(3, true),
            'barcode' => fake()->numberBetween(12365446, 98814619),
            'quantity' => fake()->numberBetween(1, 100),
            'price' => fake()->numberBetween(2, 200),
            'purchase_price' => fake()->numberBetween(2, 200),
        ];
    }
}
