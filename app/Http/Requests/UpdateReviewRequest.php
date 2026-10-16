<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルール（仕様書：レビュー投稿と同等のバリデーションを行うこと）
     */
    public function rules(): array
    {
        return [
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:1000'],
        ];
    }

    /**
     * 日本語のバリデーションメッセージ定義
     */
    public function messages(): array
    {
        return [
            'rating.required'  => '評価（星の数）を選択してください。',
            'rating.integer'   => '評価は数値で入力してください。',
            'rating.min'       => '評価は星1以上で指定してください。',
            'rating.max'       => '評価は星5以下で指定してください。',
            'comment.required' => 'コメントを変更して入力してください。',
            'comment.max'      => 'コメントは1000文字以内で入力してください。',
        ];
    }
}
