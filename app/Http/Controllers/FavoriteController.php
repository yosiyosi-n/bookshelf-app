<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * お気に入り書籍一覧画面の表示（仕様書：GET /favorites）
     */
    public function index()
    {
        $user = Auth::user();

        $favoriteBooks = $user->favoriteBooks()
            ->with('genres')
            ->withAvg('reviews', 'rating')
            ->latest('book_user.created_at')
            ->paginate(10);

        return view('favorites.index', compact('favoriteBooks'));
    }

    /**
     * お気に入り状態の切り替え
     */
    public function toggle(Book $book)
    {
        $user = Auth::user();
        $user->favoriteBooks()->toggle($book->id);
        return back();
    }
}
