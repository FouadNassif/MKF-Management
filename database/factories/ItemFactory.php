<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
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
            'description' => fake()->text(200),
            'price' => fake()->randomFloat(null, 5, 200),
            'imageURL' => 'burger.jpeg',
            'category_id' => 1,
        ];
    }
}
