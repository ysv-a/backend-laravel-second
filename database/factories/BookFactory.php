<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Books>
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
            'isbn' => $this->faker->unique()->isbn13(),
            'title' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(10, 800),
            'page' => $this->faker->numberBetween(50, 400),
            'year' => $this->faker->year(),
            'excerpt' => $this->faker->paragraph(),
        ];
    }
}
