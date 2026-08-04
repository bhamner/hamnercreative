<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Content;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Content>
 */
class ContentFactory extends Factory
{
    protected $model = Content::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'client_id' => Client::factory(),
            'description' => fake()->sentence(),
            'quantity_available' => fake()->numberBetween(1, 20),
            'price' => fake()->randomFloat(2, 10, 500),
            'in_stock' => true,
        ];
    }
}
