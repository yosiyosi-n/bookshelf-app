<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    /**
     * ランキング画面の表示（仕様書：GET /ranking）
     */
    public function index()
    {
        // ★ 教材のBlade仕様（評価ランキング TOP 10）に完全適合するクエリ
        $rankedBooks = Book::withCount('reviews') // 1. レビュー件数（$book->reviews_count）を自動集計
            ->withAvg('reviews', 'rating') // 2. レビュー平均点（$book->reviews_avg_rating）を自動計算
            ->orderByDesc('reviews_avg_rating') // 3. 平均評価が高い順に並び替え
            ->orderByDesc('reviews_count') // 4. 平均評価が同じならレビュー件数が多い順
            ->take(10) // 5. 上位10件（TOP 10）を取得
            ->get();

        // 教材のテンプレートが探している「$rankedBooks」という変数名でビューに渡します
        return view('ranking.index', compact('rankedBooks'));
    }
}
