<?php

use App\Http\Controllers\Api\v1\BookApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API v1 エンドポイント定義（公開API仕様書完全準拠：基礎段階・認証なし）
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    // apiResourceにより、一覧・詳細・登録・更新・削除の5つのルートが一撃で自動生成されます
    // URLは自動的に /api/v1/books および /api/v1/books/{book} になります
    Route::apiResource('books', BookApiController::class);
});
