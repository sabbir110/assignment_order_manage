<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,  // Generates a random product name
            'price' => $this->faker->randomFloat(2, 10, 100),  // Random price between 10 and 100
            'stock' => $this->faker->numberBetween(1, 100),  // Random stock between 1 and 100
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
