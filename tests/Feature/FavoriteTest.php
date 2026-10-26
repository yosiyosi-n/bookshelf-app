<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ログイン状態でお気に入り一覧画面が正常に表示される
     */
    public function test_favorites_index_page_displays_correctly(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id, 'title' => 'お気に入りの本']);

        // お気に入り中間テーブルに紐付け
        $user->favoriteBooks()->attach($book->id);

        $response = $this->actingAs($user)->get(route('favorites.index'));

        $response->assertStatus(200);
        $response->assertSee('お気に入りの本');
    }

    /**
     * お気に入りのトグル（登録・解除）が正常に動作する
     */
    public function test_favorites_toggle_action_works_correctly(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        // 1回目：お気に入り登録
        $response = $this->actingAs($user)->post(route('favorites.toggle', $book));
        $this->assertDatabaseHas('book_user', ['user_id' => $user->id, 'book_id' => $book->id]);
        $response->assertRedirect();

        // 2回目：お気に入り解除
        $response = $this->actingAs($user)->post(route('favorites.toggle', $book));
        $this->assertDatabaseMissing('book_user', ['user_id' => $user->id, 'book_id' => $book->id]);
        $response->assertRedirect();
    }
}
