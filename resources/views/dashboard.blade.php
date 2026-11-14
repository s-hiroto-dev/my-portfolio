<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ダッシュボード - 就活記録アプリ</title>
    <style>
        /* 全体のレイアウト設計（2カラム用） */
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        /* ヘッダー部分（挨拶とログアウト） */
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        /* 左右2カラムのグリッドレイアウト */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr; /* 左側を広く（2）、右側を少し狭く（1） */
            gap: 20px;
        }
        @media (max-width: 900px) {
            .dashboard-grid {
                grid-template-columns: 1fr; /* 画面が狭いときは縦並び */
            }
        }
        /* カードの共通スタイル */
        .card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        .logout-btn {
            background-color: #e53e3e;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .logout-btn:hover {
            background-color: #c53030;
        }
    </style>
</head>
<body>
    <div class="container">

        <!-- 挨拶とログアウトのヘッダー -->
        <div class="header-section">
            <div>
                <h1 style="margin: 0; font-size: 22px;">ようこそダッシュボードへ、{{ Auth::user()->name }} さん！</h1>
                <p style="margin: 5px 0 0 0; color: #718096; font-size: 14px;">就活記録日記！</p>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn">ログアウトする</button>
            </form>
        </div>

        <!-- 保存成功時のメッセージ表示 -->
        @if (session('success'))
            <div style="background-color: #c6f6d5; color: #22543d; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <!-- 左右2カラムのメインエリア -->
        <div class="dashboard-grid">

            <!-- 【左側】：大きなカレンダーを表示するエリア -->
            <div class="card" style="min-height: 500px;">
                <h3 style="margin-top: 0; border-bottom: 2px solid #edf2f7; padding-bottom: 10px;">📅 就活カレンダー</h3>
                <div style="text-align: center; padding: 80px 0; color: #a0aec0;">
                    <p style="font-size: 18px; font-weight: bold; color: #4a5568;">ここに大きなカレンダーを実装していくよ！</p>
                    <p style="font-size: 14px;">日付のマスごとに、その日の学習時間やメモが書き込まれる予定です。</p>
                </div>
            </div>

            <!-- 【右側】：記録をつけるフォーム ＆ これまでの記録一覧 -->
            <div>
                <!-- 就活記録の入力フォーム -->
                <div class="card">
                    <h3 style="margin-top: 0; border-bottom: 2px solid #edf2f7; padding-bottom: 10px;">⏱️ 記録をつける</h3>
                    <form action="{{ route('study-logs.store') }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 12px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px;">向き合った時間（分）:</label>
                            <input type="number" name="duration_minutes" placeholder="例: 60" required style="padding: 8px; width: 100%; box-sizing: border-box; border: 1px solid #cbd5e0; border-radius: 4px;">
                        </div>
                        <div style="margin-bottom: 12px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px;">やったこと・メモ:</label>
                            <textarea name="memo" placeholder="例: ESの自己PR欄を修正した、企業説明会に参加した" rows="3" style="padding: 8px; width: 100%; box-sizing: border-box; border: 1px solid #cbd5e0; border-radius: 4px;"></textarea>
                        </div>
                        <button type="submit" style="background-color: #3182ce; color: white; border: none; padding: 10px; width: 100%; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: bold;">記録を保存する</button>
                    </form>
                </div>

                <!-- これまでの就活記録一覧 -->
                <div class="card">
                    <h3 style="margin-top: 0; border-bottom: 2px solid #edf2f7; padding-bottom: 10px;">📊 これまでの就活の記録</h3>
                    
                    @if($studyLogs->isEmpty())
                        <p style="color: #718096; font-size: 14px;">まだ記録がありません。上のフォームから最初の記録をつけてみましょう！</p>
                    @else
                        <ul style="list-style: none; padding: 0; margin: 0; max-height: 350px; overflow-y: auto;">
                            @foreach($studyLogs as $log)
                                <li style="padding: 10px 0; border-bottom: 1px solid #edf2f7;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <strong style="color: #3182ce; font-size: 15px;">⏱️ {{ $log->duration_minutes }} 分</strong>
                                        <span style="color: #a0aec0; font-size: 12px;">{{ $log->created_at->format('Y/m/d H:i') }}</span>
                                    </div>
                                    @if($log->memo)
                                        <p style="margin: 4px 0 0 0; color: #4a5568; font-size: 13px;">メモ: {{ $log->memo }}</p>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

        </div>
    </div>
</body>
</html>



<!--
================================================================================
【古いコードの保持】：直前まで使っていた縦並びレイアウトのコード
================================================================================
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ダッシュボード</title>
    <style>
        body { font-family: sans-serif; background-color: #f7f9fc; margin: 0; padding: 40px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        h1 { color: #333; }
        p { color: #666; }
        .logout-btn { background-color: #e53e3e; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-size: 14px; }
        .logout-btn:hover { background-color: #c53030; }
    </style>
</head>
<body>
    <div class="container">
        <h1>ようこそダッシュボードへ、{{ Auth::user()->name }} さん！</h1>
        <p>ここは認証済みのユーザーだけが見ることができるダッシュボード画面です。</p>

        @if (session('success'))
            <div style="background-color: #c6f6d5; color: #22543d; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <div style="background: #f7fafc; padding: 20px; border-radius: 6px; margin-bottom: 20px;">
            <h3>⏱️ 就活の記録をつける</h3>
            <form action="{{ route('study-logs.store') }}" method="POST">
                @csrf
                <div style="margin-bottom: 10px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">向き合った時間（分）:</label>
                    <input type="number" name="duration_minutes" placeholder="例: 60" required style="padding: 8px; width: 100%; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <div style="margin-bottom: 10px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">やったこと・メモ:</label>
                    <textarea name="memo" placeholder="例: ESの自己PR欄を修正した、企業説明会に参加した" rows="3" style="padding: 8px; width: 100%; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;"></textarea>
                </div>
                <button type="submit" style="background-color: #3182ce; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-size: 14px;">記録を保存する</button>
            </form>
        </div>

        <div style="background: #fff; padding: 20px; border: 1px solid #e2e8f0; border-radius: 6px; margin-bottom: 20px;">
            <h3>📊 これまでの就活の記録</h3>
            
            @if($studyLogs->isEmpty())
                <p style="color: #718096;">まだ記録がありません。上のフォームから最初の記録をつけてみましょう！</p>
            @else
                <ul style="list-style: none; padding: 0;">
                    @foreach($studyLogs as $log)
                        <li style="padding: 12px 0; border-bottom: 1px solid #edf2f7;">
                            <strong style="color: #3182ce; font-size: 16px;">⏱️ {{ $log->duration_minutes }} 分</strong>
                            <span style="color: #718096; font-size: 14px; margin-left: 10px;">({{ $log->created_at->format('Y年m月d日 H:i') }})</span>
                            @if($log->memo)
                                <p style="margin: 5px 0 0 0; color: #4a5568;">メモ: {{ $log->memo }}</p>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">ログアウトする</button>
        </form>
    </div>
</body>
</html>
-->