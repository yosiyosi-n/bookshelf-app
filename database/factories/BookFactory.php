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
            // 既存のユーザーからランダムに1人、登録者として紐付けます
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'title' => fake()->realText(15), // 15文字程度のリアルな本のタイトル
            'author' => fake()->name(),      // 著者名
            'isbn' => fake()->isbn13(),      // 本物の形式に近い13桁のISBNコード
            'published_date' => fake()->date(), // 出版日
            'image_url' => fake()->imageUrl(640, 480, 'books', true), // テスト用の画像URL
            'description' => fake()->realText(100), // 100文字程度のあらすじ・解説
        ];
    }
}
