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
}