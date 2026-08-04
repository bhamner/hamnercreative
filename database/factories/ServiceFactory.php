<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'order_id' => \App\Models\Order::factory(),
            'details' => fake()->sentence(),
            'quantity' => fake()->numberBetween(1, 5),
            'rate' => fake()->randomFloat(2, 50, 500),
        ];
    }
}
