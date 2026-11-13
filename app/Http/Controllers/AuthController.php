<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * ログイン画面を表示する
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * ログイン処理を実行する
     */
    public function login(Request $request)
    {
        // 1. バリデーション（入力チェック）
        $credentials = $request->validate([
            'name' => ['required'],
            'password' => ['required'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | 【ポイント】：ユーザー名（name）でログイン認証を行う
        |--------------------------------------------------------------------------
        | Laravelのデフォルトは email ですが、今回は name をIDとして使いたいので
        | キーを 'name' に指定して認証（Auth::attempt）します。
        */
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // ログイン成功時はダッシュボードやホーム画面へリダイレクト
            return redirect()->intended('/dashboard');
        }

        // 失敗した場合はエラーメッセージと共にログイン画面に戻る
        return back()->withErrors([
            'name' => 'ユーザー名またはパスワードが正しくありません。',
        ])->onlyInput('name');
    }

    /**
     * ログアウト処理を実行する
     */
    public function logout(Request $request)
    {
        // 1. ユーザーの認証状態を解除する
        Auth::logout();

        // 2. セッションを無効化し、セキュリティトークンを再生成する
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 3. ログイン画面にリダイレクトする
        return redirect('/login');
    }

    /**
     * 新規登録画面を表示する
     */
    public function showRegisterForm()
    {
        return view('register'); // 後で作る新規登録ビュー
    }

    /**
     * 新規登録処理を実行する
     */
    public function register(Request $request)
    {
        // 1. バリデーション（入力チェック）
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        // 2. ユーザーの新規作成
        $user = \App\Models\User::create([
            'name' => $request->name,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        // 3. 登録したユーザーでそのままログイン（自動ログイン）
        \Illuminate\Support\Facades\Auth::login($user);

        // 4. ダッシュボードへリダイレクト
        return redirect('/dashboard');
    }
}