<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\GenreController; // 👈 ★【追加】上部にこれを追記してください
// まだ作成していないランキングのコントローラーはコメントアウトのままにしておきます
// use App\Http\Controllers\RankingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 1. ログインなしでも見られる書籍ルート（一覧）
Route::get('/books', [BookController::class, 'index'])->name('books.index');

// 2. リンクエラーを防ぐための暫定ダミールート
Route::get('/ranking', function () { return 'ランキング画面（開発中）'; })->name('ranking.index');


// ❌ 修正前（ここに並んでいたジャンル関連のダミールート群はすべて削除します）


// 🔒 認証時（ログインユーザー）のみアクセス可能なグループ
Route::middleware('auth')->group(function () {
    // 書籍の管理機能（開通済み）
    Route::resource('books', BookController::class)->except(['index', 'show']);

    // ★【本物化】ジャンルの管理機能（一覧・登録・編集・更新・削除）を一括で有効化！
    Route::resource('genres', GenreController::class);

    // お気に入り関連のルート（開通済み）
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{book}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // レビュー関連のルート（開通済み）
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
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
