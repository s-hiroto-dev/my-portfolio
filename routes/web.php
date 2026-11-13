<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController; // ← 今回新しく追加したコントローラーの読み込み

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

/*
|--------------------------------------------------------------------------
| 【古い書き方】：以前、ルートファイルに直接書いていたフォームの処理
|--------------------------------------------------------------------------
*/
// 1. フォーム画面を表示するルート
// Route::get('/form', function () {
//     return view('form');
// });

// 2. フォームから送信されたデータを受け取って表示するルート
// Route::post('/result', function (Request $request) {
//     // 入力されたデータ（input_textという名前のデータ）を受け取る
//     $text = $request->input('input_text');
// 
//     // 画面にそのまま表示する
//     return '受け取ったデータ： ' . htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
// });


/*
|--------------------------------------------------------------------------
| 【新しい書き方】：コントローラー（FormController）を使うルート
|--------------------------------------------------------------------------
*/
// 1. フォーム画面の表示
Route::get('/form', [FormController::class, 'index']);

// 2. フォームの送信処理（POST）
Route::post('/form', [FormController::class, 'submit']);


//add login
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| 【新しい書き方】：コントローラー（AuthController）を使うログインのルート
|--------------------------------------------------------------------------
*/
// 1. ログイン画面を表示するルート（GETアクセス）
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// 2. ログイン処理を実行するルート（POSTアクセス）
Route::post('/login', [AuthController::class, 'login']);

// 3. ログイン成功後に移動するダッシュボード画面（仮のページ）
Route::get('/dashboard', function () {
    return 'ログイン成功！ようこそダッシュボードへ！';
})->middleware('auth');