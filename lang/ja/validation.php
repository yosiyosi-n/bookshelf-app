<?php

return [
    'required' => ':attributeは必須項目です。',
    'max' => [
        'string' => ':attributeは :max 文字以内で入力してください。',
    ],
    'min' => [
        'string' => ':attributeは :min 文字以上で入力してください。',
    ],
    'email' => ':attributeには有効なメールアドレスを入力してください。',
    'unique' => '指定された:attributeは既に使用されています。',
    'confirmed' => ':attributeが一致しません。',

    'attributes' => [
        'name' => '名前',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'title' => 'タイトル',
        'author' => '著者',
        'description' => '詳細・感想',
    ],
];
