<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\FavoriteController;
// use App\Http\Controllers\GenreController;
// use App\Http\Controllers\RankingController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

Route::get('/books/create', function () { return '書籍登録画面（開発中）'; })->name('books.create');

Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');
// Route::post('/favorites/{book}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
Route::middleware('auth')->group(function () {
    // ★ 仕様書通り：認証時はお気に入り一覧を表示し、未認証時は自動で /login にリダイレクトされます
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{book}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // ★ レビュー関連のルートを本物のコントローラーにバトンタッチ！
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store'); // 投稿保存
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit'); // 編集画面（認可必要）
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update'); // 更新処理（認過必要・FormRequest検証）
    Route::post('/reviews/{review}/like', [ReviewController::class, 'like'])->name('reviews.like'); // いいねトグル

    // ※ 今回仕様書にない index, create, show, destroy の仮ルートエラーを防ぐため、残りのリソース名だけ仮に定義
    Route::get('/reviews', function () { return 'レビュー一覧'; })->name('reviews.index');
    Route::get('/reviews/create', function () { return 'レビュー作成'; })->name('reviews.create');
    Route::get('/reviews/{review}', function () { return 'レビュー詳細'; })->name('reviews.show');
    Route::delete('/reviews/{review}', function () { return 'レビュー削除'; })->name('reviews.destroy');
});

Route::get('/genres', function () { return 'ジャンル一覧（開発中）'; })->name('genres.index');
Route::get('/genres/create', function () { return 'ジャンル作成（開発中）'; })->name('genres.create');
Route::post('/genres', function () { return 'ジャンル保存（開発中）'; })->name('genres.store');
Route::get('/genres/{genre}', function () { return 'ジャンル詳細（開発中）'; })->name('genres.show');
Route::get('/genres/{genre}/edit', function () { return 'ジャンル編集（開発中）'; })->name('genres.edit');
Route::put('/genres/{genre}', function () { return 'ジャンル更新（開発中）'; })->name('genres.update');
Route::delete('/genres/{genre}', function () { return 'ジャンル削除（開発中）'; })->name('genres.destroy');

Route::middleware('auth')->group(function () {
    // Route::resource('books', BookController::class)->except(['index', 'show']);

    // Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    // Route::post('/favorites/{book}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Route::resource('genres', GenreController::class);

    // Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');

    // Route::resource('reviews', ReviewController::class);

    // Route::post('/reviews/{review}/like', [ReviewController::class, 'like'])->name('reviews.like');
});
