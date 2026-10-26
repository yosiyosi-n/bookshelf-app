<?php

namespace Tests\Feature\Api\v1;

use App\Models\Book;
use App\Models\User;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 【GET /api/v1/books】 のテスト
     */
    public function test_api_can_get_books_index(): void
    {
        $user = User::factory()->create();
        Book::factory()->create(['user_id' => $user->id, 'title' => 'APIテスト本']);

        $response = $this->getJson('/api/v1/books');

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'APIテスト本']);
    }

    /**
     * 【GET /api/v1/books/{book}】 のテスト
     */
    public function test_api_can_get_book_detail(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id, 'title' => 'API詳細本']);

        $response = $this->getJson("/api/v1/books/{$book->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'API詳細本']);
    }

    /**
     * 【POST /api/v1/books】 のテスト
     */
    public function test_api_can_store_new_book(): void
    {
        User::factory()->create();
        $genre = Genre::factory()->create();

        $formData = [
            'title'          => 'API新規本',
            'author'         => 'API著者',
            'isbn'           => '9784999999999',
            'published_date' => '2026-01-01',
            'genres'         => [$genre->id],
        ];

        $response = $this->postJson('/api/v1/books', $formData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('books', ['title' => 'API新規本']);
    }

    /**
     * 【PUT /api/v1/books/{book}】 のテスト
     */
    public function test_api_can_update_book(): void
    {
        $user = User::factory()->create();
        $genre = Genre::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id, 'isbn' => '9784123456789']);

        $updateData = [
            'title'          => 'API更新本',
            'author'         => 'API更新著者',
            'isbn'           => '9784123456789',
            'published_date' => '2026-01-01',
            'genres'         => [$genre->id],
        ];

        $response = $this->putJson("/api/v1/books/{$book->id}", $updateData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('books', ['title' => 'API更新本']);
    }

    /**
     * 【DELETE /api/v1/books/{book}】 のテスト
     */
    public function test_api_can_delete_book(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson("/api/v1/books/{$book->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
