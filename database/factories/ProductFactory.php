<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
            'name' => fake()->word(),
            'stock' => fake()->numberBetween(0, 500),
            'image' => fake()->imageUrl(),
            'premium' => fake()->boolean(),
            'categorie_id' => fake()->numberBetween(1, 9),
            'tokens_required' => fake()->numberBetween(1, 100),
        ];
    }
}
