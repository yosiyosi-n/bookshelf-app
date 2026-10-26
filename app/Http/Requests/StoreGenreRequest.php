<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGenreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルール（仕様書：ジャンル名の必須チェックと一意性を検証すること）
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:genres,name'], // 必須かつ重複不可
        ];
    }

    /**
     * 日本語のバリデーションメッセージ定義
     */
    public function messages(): array
    {
        return [
            'name.required' => 'ジャンル名を入力してください。',
            'name.unique'   => 'このジャンル名は既に登録されています。',
            'name.max'      => 'ジャンル名は255文字以内で入力してください。',
        ];
    }
}
