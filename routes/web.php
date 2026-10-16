<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 1. ログインなしでも見られる書籍ルート（一覧）
Route::get('/books', [BookController::class, 'index'])->name('books.index');

// 2. リンクエラーを防ぐための暫定ダミールート群
Route::get('/ranking', function () { return 'ランキング画面（開発中）'; })->name('ranking.index');

Route::get('/genres', function () { return 'ジャンル一覧（開発中）'; })->name('genres.index');
Route::get('/genres/create', function () { return 'ジャンル作成（開発中）'; })->name('genres.create');
Route::post('/genres', function () { return 'ジャンル保存（開発中）'; })->name('genres.store');
Route::get('/genres/{genre}', function () { return 'ジャンル詳細（開発中）'; })->name('genres.show');
Route::get('/genres/{genre}/edit', function () { return 'ジャンル編集（開発中）'; })->name('genres.edit');
Route::put('/genres/{genre}', function () { return 'ジャンル更新（開発中）'; })->name('genres.update');
Route::delete('/genres/{genre}', function () { return 'ジャンル削除（開発中）'; })->name('genres.destroy');


// 🔒 認証時（ログインユーザー）のみアクセス可能なグループ
Route::middleware('auth')->group(function () {
    // ★【順序対策】詳細画面(show)より先にリソースを定義することで、/books/create が正しく認識されます
    Route::resource('books', BookController::class)->except(['index', 'show']);

    // お気に入り関連のルート
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{book}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // レビュー関連のルート
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::post('/reviews/{review}/like', [ReviewController::class, 'like'])->name('reviews.like');

    // レビュー用の一時仮定義
    Route::get('/reviews', function () { return 'レビュー一覧'; })->name('reviews.index');
    Route::get('/reviews/create', function () { return 'レビュー作成'; })->name('reviews.create');
    Route::get('/reviews/{review}', function () { return 'レビュー詳細'; })->name('reviews.show');
    Route::delete('/reviews/{review}', function () { return 'レビュー削除'; })->name('reviews.destroy');
});


// 3. ログインなしでも見られる書籍ルート（詳細）
// ★【順序対策】すべての書籍ルートの「一番最後」に配置することで、/books/create との衝突を完全に防ぎます
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
