<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * 新規会員登録時のバリデーションとユーザー作成（仕様書完全準拠）
     */
    public function create(array $input): User
    {
        // 仕様書通り：名前、メールアドレス、パスワードの検証と一意性の担保、および日本語化を実装
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class), // メールアドレスの一意性を担保
            ],
            'password' => $this->passwordRules(), // パスワードの標準検証ルール（confirmed含む）
        ], [
            // 仕様書通り：messages()と同等の日本語メッセージをここで自分で設計して定義
            'name.required' => '名前を入力してください。',
            'name.max' => '名前は255文字以内で入力してください。',
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => 'メールアドレスは正しいメール形式で入力してください。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            'email.unique' => 'このメールアドレスは既に登録されています。',
            'password.required' => 'パスワードを入力してください。',
            'password.confirmed' => 'パスワード（確認用）が一致しません。',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
