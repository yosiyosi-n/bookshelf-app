<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    /**
     * リクエストの実行権限をチェック（今回はコントローラー側で認可するため常に true）
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルール（仕様書：評価値の範囲を検証すること）
     */
    public function rules(): array
    {
        return [
            'book_id' => ['required', 'integer', 'exists:books,id'],
            'rating'  => ['required', 'integer', 'min:1', 'max:5'], // 1〜5の範囲
            'comment' => ['required', 'string', 'max:1000'], // 1000文字以内
        ];
    }

    /**
     * 日本語のバリデーションメッセージ定義（仕様書：具体的な文言は自分で設計すること）
     */
    public function messages(): array
    {
        return [
            'book_id.required' => '対象の書籍が指定されていません。',
            'book_id.exists'   => '指定された書籍は存在しません。',
            'rating.required'  => '評価（星の数）を選択してください。',
            'rating.integer'   => '評価は数値で入力してください。',
            'rating.min'       => '評価は星1以上で指定してください。',
            'rating.max'       => '評価は星5以下で指定してください。',
            'comment.required' => 'コメントを入力してください。',
            'comment.max'      => 'コメントは1000文字以内で入力してください。',
        ];
    }
}
