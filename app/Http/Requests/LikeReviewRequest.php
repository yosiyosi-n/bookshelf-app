<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LikeReviewRequest extends FormRequest
{
    /**
     * リクエストの実行権限チェック（認可）
     * ★ ここで自分のレビューかどうかをチェックし、自分なら自動的にエラーを発生させます
     */
    public function authorize(): bool
    {
        // ルートから「これからいいねするレビュー」を小文字で確実に取得
        $review = $this->route('review');

        if (is_object($review)) {
            // レビューの投稿者が自分自身である場合は、認可（authorize）を false にして即座に弾く
            return $review->user_id !== Auth::id();
        }

        return true;
    }

    /**
     * バリデーションルール
     * ★ 認可で弾くため、ルール自体は空っぽ（空の配列）で問題ありません
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * 日本語のバリデーションメッセージ定義
     */
    public function messages(): array
    {
        return [];
    }
}
