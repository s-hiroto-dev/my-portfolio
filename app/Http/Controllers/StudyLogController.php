<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudyLog; // ← StudyLogモデルを使えるように読み込む

class StudyLogController extends Controller
{   
    /*
    // 【旧】就活記録を保存する処理
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
    */

    // 【新しく追加】ダッシュボードを表示する処理（記録の一覧を渡す）
    public function index()
    {
        /*
        // ログイン中のユーザーの記録を、新しい順（降順: latest）に取得
        $studyLogs = auth()->user()->studyLogs()->latest()->get();

        // ダッシュボードのビューに記録のデータを渡して表示する
        return view('dashboard', compact('studyLogs'));
        */

        //add
        // ログイン中のユーザーの記録を新しい順に取得
        $studyLogs = auth()->user()->studyLogs()->latest()->get();

        // --- ここからカレンダー用のデータ作成ロジック ---
        $year = request('year', date('Y'));
        $month = request('month', date('n'));

        // 今月の初日と最終日の取得
        $firstDayOfMonth = \Carbon\Carbon::createFromDate($year, $month, 1);
        $daysInMonth = $firstDayOfMonth->daysInMonth; // 今月のトータル日数
        $startDayOfWeek = $firstDayOfMonth->dayOfWeek; // 1日の曜日（0:日曜, 1:月曜...）

        // データベースから取得した記録を「日付 (YYYY-MM-DD)」をキーにした配列に整理する
        // （カレンダーのマスにその日の記録をパッと当てはめるため）
        $logsByDate = [];
        $userLogs = auth()->user()->studyLogs()->get();
        foreach ($userLogs as $log) {
            /*
            // ====================================================================
            // 【古いコード】作成日時（created_at）を基準にしていた処理
            // ====================================================================
            $dateStr = $log->created_at->format('Y-m-d');
            */
            // ====================================================================
            // 【新しいコード】実際に就活を行った日（study_date）を基準にする処理
            // ====================================================================
            $dateStr = \Carbon\Carbon::parse($log->study_date)->format('Y-m-d');

            // 同じ日に複数ある場合は時間を合計するか、最新を格納（ここではシンプルに配列にまとめる）
            $logsByDate[$dateStr][] = $log;
        }
        // ------------------------------------------------

        // ダッシュボードのビューに記録とカレンダー情報を一緒に渡す
        return view('dashboard', compact('studyLogs', 'year', 'month', 'daysInMonth', 'startDayOfWeek', 'logsByDate'));
    
    }

    // 【新しく追加】就活記録を保存する処理
    public function store(Request $request)
    {
        // 1. データのバリデーション（入力チェック）
        // ※「時間は必須・数字であること」「メモは文字列」「日付は必須かつ日付形式であること」というルール
        $request->validate([
            'duration_minutes' => 'required|integer|min:1',
            'memo' => 'nullable|string|max:500',
            'study_date' => 'required|date', // 【追加】日付のバリデーション
        ]);

        // 2. データベースに保存
        StudyLog::create([
            'user_id' => auth()->id(), // 現在ログインしているユーザーのIDを自動でセット
            'duration_minutes' => $request->duration_minutes,
            'memo' => $request->memo,
            'study_date' => $request->study_date, // 【追加】選択された日付を保存
        ]);

        // 3. 保存が終わったらダッシュボード画面に引き返す（「記録したよ！」というメッセージ付き）
        return redirect()->back()->with('success', '就活の記録を保存しました！お疲れ様です！');
    }
}