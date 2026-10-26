<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGenreRequest;
use App\Http\Requests\UpdateGenreRequest;  // 👈 先ほど作成したFormRequestを読み込み
use App\Models\Genre; // 👈 先ほど作成したFormRequestを読み込み

class GenreController extends Controller
{
    /**
     * ジャンル一覧画面の表示（仕様書：GET /genres）
     */
    public function index()
    {
        $genres = Genre::all();

        return view('genres.index', compact('genres'));
    }

    /**
     * ジャンル登録画面の表示（仕様書：GET /genres/create）
     */
    public function create()
    {
        return view('genres.create');
    }

    /**
     * ジャンルの登録・保存処理（仕様書：POST /genres）
     */
    public function store(StoreGenreRequest $request)
    {
        // 1. FormRequestで検証済みの安全なデータを取得
        $validated = $request->validated();

        // 2. ジャンルを新しく登録
        Genre::create([
            'name' => $validated['name'],
        ]);

        // 3. 一覧画面へ成功メッセージ付きでリダイレクト
        return redirect()->route('genres.index')->with('success', 'ジャンルを登録しました。');
    }

    /**
     * ジャンル詳細画面の表示（仕様書：GET /genres/{genre}）
     */
    public function show(Genre $genre)
    {
        return view('genres.show', compact('genre'));
    }

    /**
     * ジャンル編集画面の表示（仕様書：GET /genres/{genre}/edit）
     */
    public function edit(Genre $genre)
    {
        return view('genres.edit', compact('genre'));
    }

    /**
     * ジャンルの更新処理（仕様書：PUT /genres/{genre}）
     */
    public function update(UpdateGenreRequest $request, Genre $genre)
    {
        // 1. FormRequestで検証済みのデータを取得（自身のレコード除外済み）
        $validated = $request->validated();

        // 2. ジャンル名を更新
        $genre->update([
            'name' => $validated['name'],
        ]);

        // 3. 一覧画面へ成功メッセージ付きでリダイレクト
        return redirect()->route('genres.index')->with('success', 'ジャンル名を更新しました。');
    }

    /**
     * ジャンルの削除処理（仕様書：DELETE /genres/{genre}）
     */
    public function destroy(Genre $genre)
    {
        // ジャンルを削除
        $genre->delete();

        return redirect()->route('genres.index')->with('success', 'ジャンルを削除しました。');
    }
}
