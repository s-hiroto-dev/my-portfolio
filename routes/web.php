<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//add1
Route::get('/hello', function () {
    return 'Hello World! 未経験からのポートフォリオ作成中';
});

//add2
use App\Http\Controllers\HelloController; // ① コントローラーを読み込む
// ② /hello にアクセスしたら HelloController の index メソッドを呼ぶ
Route::get('/hello', [HelloController::class, 'index']);
