<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * 書籍一覧画面の表示
     */
    public function index()
    {
        // 1. Blade（一覧）が必要としているデータを最適にクエリする
        // - with('genres'): 本に紐づくジャンル一覧をまとめて取得（N+1問題の対策）
        // - withAvg('reviews', 'rating'): レビューの星の平均点を自動計算して 'reviews_avg_rating' カラムとして追加
        $books = Book::with('genres')
            ->withAvg('reviews', 'rating')
            ->latest() // 新着順（IDの降順）に並び替え
            ->paginate(9); // 1ページに9件表示（Bladeの $books->links() に完全連動）

        // 2. 用意されている一覧画面のビュー（books/index.blade.php）にデータを渡す
        return view('books.index', compact('books'));
    }

    /**
     * 書籍詳細画面の表示（★一覧画面の動作確認ができたら中身を実装します）
     */
    public function show(Book $book)
    {
        // 開発中のため、一旦一覧に戻るか真っ白な画面になります
    }
}
