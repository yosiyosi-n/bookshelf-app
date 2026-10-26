<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 【RankingController のテスト】
     * 評価ランキングTOP10画面が正常に集計されて表示される
     */
    public function test_ranking_page_displays_top_rated_books_correctly(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id, 'title' => 'ランキング1位の本']);

        // 平均評価（reviews_avg_rating）と件数がBladeで計算できるようにレビューを作成
        Review::create([
            'book_id' => $book->id,
            'user_id' => $user->id,
            'rating'  => 5,
            'comment' => '最高！',
        ]);

        $response = $this->get(route('ranking.index'));

        $response->assertStatus(200);
        $response->assertSee('ランキング1位の本');
        $response->assertSee('5.0'); // 平均評価が出ていること
    }

    /**
     * 【Fortify / CreateNewUser のテスト】
     * 新規会員登録のバリデーションとユーザー作成が正常に動作する
     */
    public function test_user_registration_validation_and_creation_works(): void
    {
        $registerData = [
            'name'                  => '新規テストユーザー',
            'email'                 => 'newuser@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ];

        // Fortifyの登録エンドポイント（POST /register）へデータを送信
        $response = $this->post('/register', $registerData);

        // データベースにユーザーが追加されていることを検証
        $this->assertDatabaseHas('users', [
            'name'  => '新規テストユーザー',
            'email' => 'newuser@example.com',
        ]);
        $response->assertRedirect();
    }
}
