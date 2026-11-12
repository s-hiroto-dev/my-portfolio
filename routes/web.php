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

//add3
use Illuminate\Http\Request;

// 1. フォーム画面を表示するルート
Route::get('/form', function () {
    return view('form');
});

// 2. フォームから送信されたデータを受け取って表示するルート
Route::post('/result', function (Request $request) {
    // 入力されたデータ（input_textという名前のデータ）を受け取る
    $text = $request->input('input_text');

    // 画面にそのまま表示する
    return '受け取ったデータ： ' . htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
});
