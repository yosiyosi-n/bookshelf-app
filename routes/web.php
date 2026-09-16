<?php

use App\Http\Controllers\BookController;
// use App\Http\Controllers\FavoriteController;
// use App\Http\Controllers\GenreController;
// use App\Http\Controllers\RankingController;
// use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

Route::get('/books/create', function () { return '書籍登録画面（開発中）'; })->name('books.create');
Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');
Route::get('/favorites', function () { return 'お気に入り画面（開発中）'; })->name('favorites.index');
Route::post('/favorites/{book}/toggle', function () { return 'お気に入りトグル（開発中）'; })->name('favorites.toggle');
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
