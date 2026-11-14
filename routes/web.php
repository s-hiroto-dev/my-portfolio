<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController; // ← 今回新しく追加したコントローラーの読み込み
use App\Http\Controllers\StudyLogController; //ここを新しく追加！

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
/*
Route::get('/dashboard', function () {
    return 'ログイン成功！ようこそダッシュボードへ！';
})->middleware('auth');
*/
//logout機能追加
// ログイン成功後に移動するダッシュボード画面
/*
// 【古い書き方】以前、ルートファイルに直接HTML文字列を書いていたコード
Route::get('/dashboard', function () {
    return '
        <h1>ログイン成功！ようこそダッシュボードへ！</h1>
        <form action="/logout" method="POST">
            ' . csrf_field() . '
            <button type="submit">ログアウトする</button>
        </form>
    ';
})->middleware('auth');
*/

//add MVC 役割分担のため、web.phpにはhtml処理を書かないで中継だけにする
// 【新しい書き方】ビューファイル（dashboard.blade.php）を呼び出すルート
//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware('auth');
// ↓
// 今までは routes/web.php の中で直接 return view('dashboard'); していたけれど、
//これからはさっき作った StudyLogController の index メソッドを通すように
// 【変更後】ダッシュボード表示をコントローラー経由にする
Route::get('/dashboard', [StudyLogController::class, 'index'])->name('dashboard')->middleware('auth');

//add
// ログアウト処理を実行するルート（POSTアクセス）
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//add
// --- 新規登録用のルート ---
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

//add
// --- 就活記録用のルート ---
Route::post('/study-logs', [StudyLogController::class, 'store'])->name('study-logs.store')->middleware('auth');