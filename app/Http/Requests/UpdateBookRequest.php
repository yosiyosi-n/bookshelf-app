<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルール
     */
    public function rules(): array
    {
        // ルートパラメータから現在編集中の書籍データを取得
        $book = $this->route('book');
        $bookId = is_object($book) ? $book->id : $book;

        return [
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            // 一意性チェック(unique)で、自分自身の書籍IDを除外する指示を追記
            'isbn' => ['required', 'digits:13', 'unique:books,isbn,'.$bookId],
            'published_date' => ['required', 'date'],
            'description' => ['nullable', 'string', 'max:2000'],
            'image_url' => ['nullable', 'url'],
            'genres' => ['required', 'array', 'min:1'],
            'genres.*' => ['integer', 'exists:genres,id'],
        ];
    }

    /**
     * 日本語のバリデーションメッセージ定義
     */
    public function messages(): array
    {
        return [
            'title.required' => '書籍のタイトルを入力してください。',
            'author.required' => '著者名を入力してください。',
            'isbn.required' => 'ISBNを入力してください。',
            'isbn.digits' => 'ISBNは13桁の数値で入力してください。',
            'isbn.unique' => 'このISBNは既に他の書籍で登録されています。',
            'published_date.required' => '出版日を入力してください。',
            'published_date.date' => '出版日には有効な日付を入力してください。',
            'image_url.url' => '画像URLには正しいURL形式を入力してください。',
            'genres.required' => 'ジャンルは1つ以上選択してください。',
            'genres.min' => 'ジャンルは1つ以上選択してください。',
        ];
    }
}
