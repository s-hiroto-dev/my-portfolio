<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ダッシュボード</title>
    <!-- 簡易的なスタイリング（後からCSSファイルやBootstrap等に変えてもOK！） -->
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
        <!-- ログインしているユーザーのカスタムユーザー名（nameカラム）を表示 -->
        <h1>ようこそダッシュボードへ、{{ Auth::user()->name }} さん！</h1>
        <p>ここは認証済みのユーザーだけが見ることができるダッシュボード画面です。</p>

        <!-- 【新しく追加】保存成功時のメッセージ表示 -->
        @if (session('success'))
            <div style="background-color: #c6f6d5; color: #22543d; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <!-- 【新しく追加】就活記録の入力フォーム -->
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

        <!-- 【新しく追加】これまでの就活記録一覧 -->
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

        <!-- ログアウト用のフォーム（POST送信とCSRF保護） -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">ログアウトする</button>
        </form>
    </div>
</body>
</html>