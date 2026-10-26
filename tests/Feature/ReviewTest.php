<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ログイン状態でレビューの投稿・保存が正常に動作する
     */
    public function test_authenticated_user_can_store_review(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        $formData = [
            'book_id' => $book->id,
            'rating' => 5,
            'comment' => '最高の一冊です。',
        ];

        $response = $this->actingAs($user)->post(route('reviews.store'), $formData);

        $this->assertDatabaseHas('reviews', [
            'book_id' => $book->id,
            'user_id' => $user->id,
            'rating' => 5,
            'comment' => '最高の一冊です。',
        ]);
        $response->assertStatus(302);
    }

    /**
     * 他人のレビューに対して「いいね」のトグルが正常に動作する
     */
    public function test_user_can_like_other_users_review(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create(); // レビュー投稿者
        $book = Book::factory()->create(['user_id' => $user2->id]);

        $review = Review::create([
            'book_id' => $book->id,
            'user_id' => $user2->id,
            'rating' => 4,
            'comment' => '他人のコメント',
        ]);

        // user1がログインしてuser2のレビューにいいねする
        $response = $this->actingAs($user1)->post(route('reviews.like', $review));

        $this->assertDatabaseHas('review_user', ['user_id' => $user1->id, 'review_id' => $review->id]);
        $response->assertStatus(302);
    }

    /**
     * 自分のレビューにいいねしようとすると、FormRequestの認可ガードにより403エラーが発生する
     */
    public function test_user_cannot_like_own_review_returns_403(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        $review = Review::create([
            'book_id' => $book->id,
            'user_id' => $user->id, // 自分が投稿したレビュー
            'rating' => 5,
            'comment' => '自分のコメント',
        ]);

        // 自分のレビューにいいねを試みる
        $response = $this->actingAs($user)->post(route('reviews.like', $review));

        // 403 Forbidden（この行為は許可されていません。）が返ってくることを検証
        $response->assertStatus(403);
    }
}
