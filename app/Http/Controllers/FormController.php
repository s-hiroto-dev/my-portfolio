<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    // フォーム画面を表示するメソッド
    public function index()
    {
        return view('form');
    }

    // フォームの送信データを受け取るメソッド
    public function submit(Request $request)
    {
        // 1. バリデーション（入力チェック）
        $validated = $request->validate([
            'name' => 'required|max:50',  // 必須・最大50文字
            'email' => 'required|email', // 必須・有効なメール形式
        ]);

        // 2. チェックを通過したら結果画面（result.blade.php）にデータを渡す
        return view('result', ['data' => $validated]);
    }
}