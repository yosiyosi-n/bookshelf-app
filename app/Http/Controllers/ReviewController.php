<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Requests\LikeReviewRequest; // 👈 ★【追加】作成したLikeReviewRequestを読み込み
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * レビューの投稿・保存処理
     */
    public function store(StoreReviewRequest $request)
    {
        $validated = $request->validated();

        Review::create([
            'book_id' => $validated['book_id'],
            'user_id' => Auth::id(),
            'rating'  => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->route('books.show', $validated['book_id'])->with('success', 'レビューを投稿しました！');
    }

    /**
     * レビュー編集画面の表示
     */
    public function edit(Review $review)
    {
        abort_if($review->user_id !== Auth::id(), 403, '他人のレビューは編集できません。');

        return view('reviews.edit', compact('review'));
    }

    /**
     * レビューの更新処理
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        abort_if($review->user_id !== Auth::id(), 403, '他人のレビューは更新できません。');

        $validated = $request->validated();

        $review->update([
            'rating'  => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->route('books.show', $review->book_id)->with('success', 'レビューを更新しました！');
    }

    /**
     * レビューに対する「いいね」状態の切り替え
     * (引数を Review $review から LikeReviewRequest $request に変更)
     */
    public function like(LikeReviewRequest $request, Review $review)
    {
        // ★ ここに到達した時点で、LikeReviewRequestによる「自分のレビューかどうかの検証」は100%通過しています！
        $user = Auth::user();

        // 安全にトグル処理を実行
        $user->likedReviews()->toggle($review->id);

        return back();
    }
}
