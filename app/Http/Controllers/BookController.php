<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use App\Http\Requests\StoreBookRequest;  // 👈 先ほど作成したFormRequestを読み込み
use App\Http\Requests\UpdateBookRequest; // 👈 先ほど作成したFormRequestを読み込み
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * 書籍一覧画面の表示
     */
    public function index()
    {
        $books = Book::with('genres')
            ->withAvg('reviews', 'rating')
            ->latest()
            ->paginate(9);

        return view('books.index', compact('books'));
    }

    /**
     * 書籍登録画面の表示（仕様書：GET /books/create）
     */
    public function create()
    {
        // 登録フォームのセレクトボックスやチェックボックスで選べるように全ジャンルを取得
        $genres = Genre::all();
        return view('books.create', compact('genres'));
    }

    /**
     * 書籍の登録・保存処理（仕様書：POST /books）
     */
    public function store(StoreBookRequest $request)
    {
        // 1. FormRequest（StoreBookRequest）で検証済みの安全なデータを取得
        $validated = $request->validated();

        // 2. 書籍テーブルに基本情報を登録
        $book = Book::create([
            'title'          => $validated['title'],
            'author'         => $validated['author'],
            'isbn'           => $validated['isbn'],
            'published_date' => $validated['published_date'],
            'description'    => $validated['description'] ?? null,
            'image_url'      => $validated['image_url'] ?? null,
        ]);

        // 3. 中間テーブル（book_genre）に選択されたジャンルID配列を紐付け（1つ以上必須）
        $book->genres()->sync($validated['genres']);

        // 4. 登録された書籍の詳細画面へ成功メッセージ付きで移動
        return redirect()->route('books.show', $book->id)->with('success', '書籍を登録しました。');
    }

    /**
     * 書籍詳細画面の表示
     */
    public function show(Book $book)
    {
        $book->load(['genres', 'reviews.user', 'reviews.likedByUsers']);
        return view('books.show', compact('book'));
    }

    /**
     * 書籍編集画面の表示（仕様書：GET /books/{book}/edit）
     */
    public function edit(Book $book)
    {
        // 既存の登録情報、および選択肢としての全ジャンルをビューに渡す
        $genres = Genre::all();
        return view('books.edit', compact('book', 'genres'));
    }

    /**
     * 書籍の更新処理（仕様書：PUT /books/{book}）
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        // 1. FormRequest（UpdateBookRequest）で検証済みの安全なデータを取得
        // ★ ここに到達した時点で、ISBNの一意性チェック（自分を除外）も完全に通過しています
        $validated = $request->validated();

        // 2. 書籍データの基本情報を更新
        $book->update([
            'title'          => $validated['title'],
            'author'         => $validated['author'],
            'isbn'           => $validated['isbn'],
            'published_date' => $validated['published_date'],
            'description'    => $validated['description'] ?? null,
            'image_url'      => $validated['image_url'] ?? null,
        ]);

        // 3. 中間テーブルのジャンル紐付けを最新の選択内容で一括更新（シンク）
        $book->genres()->sync($validated['genres']);

        // 4. 更新した書籍の詳細画面へリダイレクト
        return redirect()->route('books.show', $book->id)->with('success', '書籍情報を更新しました。');
    }

    /**
     * 書籍の削除処理（仕様書：DELETE /books/{book}）
     */
    public function destroy(Book $book)
    {
        // 書籍を削除（紐づく中間テーブルの削除等はマイグレーションのON DELETE CASCADEで自動処理されます）
        $book->delete();

        // 書籍一覧画面へ戻す
        return redirect()->route('books.index')->with('success', '書籍を削除しました。');
    }
}
