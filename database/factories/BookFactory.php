<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\odel=Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'author' =>fake()->name,
            'created_at' => $createdAt = fake()->dateTimeBetween('-2 years'),
            'updated_at' => fake()->dateTimeBetween($createdAt, 'now')
        ];
    }
}
