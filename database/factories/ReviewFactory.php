<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // ランダムなユーザーと本を紐付けます
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'book_id' => Book::inRandomOrder()->first()?->id ?? Book::factory(),
            // 共有いただいたBladeの仕様（1〜5の星）に合わせて数値をランダム生成
            'rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->realText(50), // 50文字程度の感想文
        ];
    }
}
