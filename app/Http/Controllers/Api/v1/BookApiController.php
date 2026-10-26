<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\JsonResponse;

class BookApiController extends Controller
{
    /**
     * 【GET /api/v1/books】 書籍一覧を取得する（認証：不要）
     */
    public function index(): JsonResponse
    {
        // ジャンルとレビュー平均、件数を含めて最新順に10件ずつ取得（仕様書通り）
        $books = Book::with('genres')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->latest()
            ->paginate(10);

        return response()->json([
            'status'  => 'success',
            'message' => '書籍一覧を正常に取得しました。',
            'data'    => $books
        ], 200);
    }

    /**
     * 【GET /api/v1/books/{book}】 書籍詳細を取得する（認証：不要）
     */
    public function show(Book $book): JsonResponse
    {
        // 該当書籍のリレーション（ジャンル・レビュー）をロード
        $book->load(['genres', 'reviews.user']);

        return response()->json([
            'status'  => 'success',
            'message' => '書籍詳細を正常に取得しました。',
            'data'    => $book
        ], 200);
    }

    /**
     * 【POST /api/v1/books】 書籍を新規登録する（認証：不要）
     */
    public function store(StoreBookRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // 基礎段階では認証なしのため、便宜上システムの最初のユーザー(ID:1)を作成者としてセット
        $userId = \App\Models\User::first()?->id ?? 1;

        $book = Book::create([
            'user_id'        => $userId,
            'title'          => $validated['title'],
            'author'         => $validated['author'],
            'isbn'           => $validated['isbn'],
            'published_date' => $validated['published_date'],
            'description'    => $validated['description'] ?? null,
            'image_url'      => $validated['image_url'] ?? null,
        ]);

        // ジャンルの中間テーブル紐付け
        $book->genres()->sync($validated['genres']);

        return response()->json([
            'status'  => 'success',
            'message' => '書籍を新規登録しました。',
            'data'    => $book->load('genres')
        ], 201); // 201 Created
    }

    /**
     * 【PUT /api/v1/books/{book}】 書籍を更新する（認証：不要）
     */
    public function update(UpdateBookRequest $request, Book $book): JsonResponse
    {
        $validated = $request->validated();

        $book->update([
            'title'          => $validated['title'],
            'author'         => $validated['author'],
            'isbn'           => $validated['isbn'],
            'published_date' => $validated['published_date'],
            'description'    => $validated['description'] ?? null,
            'image_url'      => $validated['image_url'] ?? null,
        ]);

        $book->genres()->sync($validated['genres']);

        return response()->json([
            'status'  => 'success',
            'message' => '書籍情報を更新しました。',
            'data'    => $book->load('genres')
        ], 200);
    }

    /**
     * 【DELETE /api/v1/books/{book}】 書籍を削除する（認証：不要）
     */
    public function destroy(Book $book): JsonResponse
    {
        $book->delete();

        return response()->json([
            'status'  => 'success',
            'message' => '書籍を削除しました。'
        ], 200);
    }
}
