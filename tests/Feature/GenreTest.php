<?php

namespace Tests\Feature;

use App\Models\Genre;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ログイン状態でジャンル一覧が正常に表示される
     */
    public function test_genres_index_page_displays_correctly(): void
    {
        $user = User::factory()->create();
        $genre = Genre::create(['name' => 'テスト小説']);

        $response = $this->actingAs($user)->get(route('genres.index'));

        $response->assertStatus(200);
        $response->assertSee('テスト小説');
    }

    /**
     * ログイン状態でジャンルの新規登録が正常に動作する
     */
    public function test_authenticated_user_can_store_new_genre(): void
    {
        $user = User::factory()->create();
        $formData = ['name' => '新しいジャンル'];

        $response = $this->actingAs($user)->post(route('genres.store'), $formData);

        $this->assertDatabaseHas('genres', ['name' => '新しいジャンル']);
        $response->assertRedirect(route('genres.index'));
    }

    /**
     * ログイン状態でジャンルの更新が正常に動作する
     */
    public function test_authenticated_user_can_update_genre(): void
    {
        $user = User::factory()->create();
        $genre = Genre::create(['name' => '古いジャンル']);
        $updateData = ['name' => '更新後のジャンル'];

        $response = $this->actingAs($user)->put(route('genres.update', $genre), $updateData);

        $this->assertDatabaseHas('genres', [
            'id' => $genre->id,
            'name' => '更新後のジャンル',
        ]);
        $response->assertRedirect(route('genres.index'));
    }

    /**
     * ログイン状態でジャンルの削除が正常に動作する
     */
    public function test_authenticated_user_can_delete_genre(): void
    {
        $user = User::factory()->create();
        $genre = Genre::create(['name' => '削除対象ジャンル']);

        $response = $this->actingAs($user)->delete(route('genres.destroy', $genre));

        $this->assertDatabaseMissing('genres', ['id' => $genre->id]);
        $response->assertRedirect(route('genres.index'));
    }
}
