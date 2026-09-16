<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
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
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'title' => fake()->realText(15),
            'author' => fake()->name(),
            'isbn' => fake()->isbn13(),
            'published_date' => fake()->date(),
            'image_url' => fake()->imageUrl(640, 480, 'books', true),
            'description' => fake()->realText(100),
        ];
    }
}
