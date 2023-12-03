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
            'article' => $this->faker->vendorCode(),
            'name' => $this->faker->words(1,3),
            'unit' => 'шт',
            'quantity' => $this->faker->numberBetween(1000, 3000000),
            'price' => $this->faker->numberBetween(300, 10000),
        ];
    }
}
