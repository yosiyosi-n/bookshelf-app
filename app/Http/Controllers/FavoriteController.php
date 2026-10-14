<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * お気に入り状態の切り替え（トグル処理）
     */
    public function toggle(Book $book)
    {
        // 1. 現在ログインしているユーザーを取得
        $user = Auth::user();

        // 2. toggle() メソッドを使い、すでに登録されていれば解除、なければ登録を1行で実行
        // - userモデルの favoriteBooks() リレーション（多対多）経由で中間テーブルを操作します
        $user->favoriteBooks()->toggle($book->id);

        // 3. 元の画面（書籍詳細画面など）にスムーズに戻す
        return back();
    }
}
