<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudyLog; // ← StudyLogモデルを使えるように読み込む

class StudyLogController extends Controller
{
    // 【新しく追加】就活記録を保存する処理
    public function store(Request $request)
    {
        // 1. データのバリデーション（入力チェック）
        // ※「時間は必須・数字であること」「メモは文字列であること（空でもOK）」というルール
        $request->validate([
            'duration_minutes' => 'required|integer|min:1',
            'memo' => 'nullable|string|max:500',
        ]);

        // 2. データベースに保存
        StudyLog::create([
            'user_id' => auth()->id(), // 現在ログインしているユーザーのIDを自動でセット
            'duration_minutes' => $request->duration_minutes,
            'memo' => $request->memo,
        ]);

        // 3. 保存が終わったらダッシュボード画面に引き返す（「記録したよ！」というメッセージ付き）
        return redirect()->back()->with('success', '就活の記録を保存しました！お疲れ様です！');
    }

    // 【新しく追加】ダッシュボードを表示する処理（記録の一覧を渡す）
    public function index()
    {
        // ログイン中のユーザーの記録を、新しい順（降順: latest）に取得
        $studyLogs = auth()->user()->studyLogs()->latest()->get();

        // ダッシュボードのビューに記録のデータを渡して表示する
        return view('dashboard', compact('studyLogs'));
    }
}