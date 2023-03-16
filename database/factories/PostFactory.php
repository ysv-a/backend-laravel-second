<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'slug' => $this->faker->unique()->slug(),
            'name' => $this->faker->sentence(),
            'content' => $this->faker->realText(1200),
            'excerpt' => $this->faker->paragraph(),
        ];
    }
}
