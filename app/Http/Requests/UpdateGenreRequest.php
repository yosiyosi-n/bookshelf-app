<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGenreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルール（仕様書：ジャンル登録と同等のバリデーション、かつ自身のレコードを除外）
     */
    public function rules(): array
    {
        $genre = $this->route('genre');
        $genreId = is_object($genre) ? $genre->id : $genre;

        return [
            'name' => ['required', 'string', 'max:255', 'unique:genres,name,'.$genreId],
        ];
    }

    /**
     * 日本語のバリデーションメッセージ定義
     */
    public function messages(): array
    {
        return [
            'name.required' => 'ジャンル名を入力してください。',
            'name.unique' => 'このジャンル名は既に他のジャンルで使用されています。',
            'name.max' => 'ジャンル名は255文字以内で入力してください。',
        ];
    }
}
