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
            flex-wrap: wrap; /* 【追加】画面が狭いときに自然に折り返す */
            gap: 15px;      /* 【追加】要素同士の間隔を空ける */
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
            <!-- ==================================================================== -->
            <!-- 【旧コード】連続取り組み日数のバッジ表示 -->
            <!-- ストリークバッジが単体で置かれていたために、分割表示され縦になってしまっていた -->
            <!-- ==================================================================== -->
            <!--
            <div style="display: flex; align-items: center; background: #fffaf0; border: 1px solid #feebc8; padding: 8px 16px; border-radius: 6px;">
                <span style="font-size: 20px; margin-right: 8px;">🔥</span>
                <div>
                    <div style="font-size: 11px; color: #c05621; font-weight: bold;">連続継続中</div>
                    <div style="font-size: 16px; font-weight: bold; color: #dd6b20;">{{ $streakDays }} 日目</div>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn">ログアウトする</button>
            </form>
            -->
            <!-- 【追加】右側の「バッジ」と「ログアウトボタン」をひとまとめのグループにした -->
            <div style="display: flex; align-items: center; gap: 15px;">
          
                <!-- 【追加】総就活時間のバッジ表示 -->
                <div style="display: flex; align-items: center; background: #ebf8ff; border: 1px solid #bee3f8; padding: 6px 14px; border-radius: 6px; white-space: nowrap;">
                    <span style="font-size: 20px; margin-right: 8px;">⏳</span>
                    <div>
                        <div style="font-size: 10px; color: #2b6cb0; font-weight: bold; line-height: 1;">総就活時間</div>
                        <div style="font-size: 15px; font-weight: bold; color: #3182ce; line-height: 1.2;">{{ $totalMinutes }} 分</div>
                    </div>
                </div>           
                
                @php
                // 継続日数に応じて炎のサイズを大きくする（例: 基本20pxに、日数×3pxを足す。最大100pxまで）
                $flameSize = min(20 + ($streakDays * 3), 100); 
                @endphp

                <div style="display: flex; align-items: center; background: #fffaf0; border: 1px solid #feebc8; padding: 6px 14px; border-radius: 6px; white-space: nowrap;">
                    <!-- <span style="font-size: 20px; margin-right: 8px;">🔥</span> -->
                     <!-- 変更　日数に応じて大きさが変わる炎 -->
                    <span style="font-size: {{ $flameSize }}px; margin-right: 8px;">🔥</span>
                    <div>
                        <div style="font-size: 10px; color: #c05621; font-weight: bold; line-height: 1;">連続継続中</div>
                        <div style="font-size: 15px; font-weight: bold; color: #dd6b20; line-height: 1.2;">{{ $streakDays }} 日目</div>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="logout-btn">ログアウトする</button>
                </form>
            </div>
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
                <h3 style="margin-top: 0; border-bottom: 2px solid #edf2f7; padding-bottom: 10px; display: flex; justify-content: space-between; align-items: center;">
                    <span>📅 就活カレンダー ({{ $year }}年 {{ $month }}月)</span>
                </h3>

                <!-- カレンダーのテーブル表 -->
                <table style="width: 100%; border-collapse: collapse; table-layout: fixed;">
                    <thead>
                        <tr style="background-color: #f7fafc; color: #4a5568; font-size: 14px;">
                            <th style="padding: 10px; border: 1px solid #e2e8f0; color: #e53e3e;">日</th>
                            <th style="padding: 10px; border: 1px solid #e2e8f0;">月</th>
                            <th style="padding: 10px; border: 1px solid #e2e8f0;">火</th>
                            <th style="padding: 10px; border: 1px solid #e2e8f0;">水</th>
                            <th style="padding: 10px; border: 1px solid #e2e8f0;">木</th>
                            <th style="padding: 10px; border: 1px solid #e2e8f0;">金</th>
                            <th style="padding: 10px; border: 1px solid #e2e8f0; color: #3182ce;">土</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $currentDay = 1;
                            $totalCells = $startDayOfWeek + $daysInMonth;
                            $weeks = ceil($totalCells / 7);
                        @endphp

                        @for ($i = 0; $i < $weeks; $i++)
                            <tr>
                                @for ($j = 0; $j < 7; $j++)
                                    @php
                                        $cellIndex = $i * 7 + $j;
                                        $isCellActive = ($cellIndex >= $startDayOfWeek && $currentDay <= $daysInMonth);
                                    @endphp

                                    <td style="height: 80px; vertical-align: top; border: 1px solid #e2e8f0; padding: 6px; background-color: {{ $isCellActive ? '#fff' : '#f7fafc' }};">
                                        @if ($isCellActive)
                                            @php
                                                $dateString = sprintf('%04d-%02d-%02d', $year, $month, $currentDay);
                                                $dayLogs = $logsByDate[$dateString] ?? [];
                                                $totalMinutes = collect($dayLogs)->sum('duration_minutes');
                                            @endphp

                                            <!-- 日付の数字 -->
                                            <div style="font-size: 13px; font-weight: bold; color: #2d3748; margin-bottom: 4px;">
                                                {{ $currentDay }}
                                            </div>

                                            <!-- その日の記録がある場合の表示 -->
                                            @if (count($dayLogs) > 0)
                                                <!-- ==================================================================== -->
                                                <!-- 【新しいコード】時間を合算せず、記録ごとに個別に箇条書きで表示する -->
                                                <!-- ==================================================================== -->
                                                @foreach ($dayLogs as $log)
                                                    <div style="background-color: #ebf8ff; border-left: 3px solid #3182ce; padding: 2px 4px; font-size: 10px; border-radius: 2px; margin-bottom: 2px;">
                                                        <div style="font-weight: bold; color: #2b6cb0;">⏱️ {{ $log->duration_minutes }}分</div>
                                                        @if($log->memo)
                                                            <div style="color: #4a5568; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $log->memo }}">
                                                                {{ $log->memo }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach

                                                <!-- ==================================================================== -->
                                                <!-- 【古いコード】時間を合算して1つのブロックにまとめて表示していた頃のコード -->
                                                <!-- ==================================================================== -->
                                                <!--
                                                @php
                                                    $totalMinutes = collect($dayLogs)->sum('duration_minutes');
                                                @endphp
                                                <div style="background-color: #ebf8ff; border-left: 3px solid #3182ce; padding: 3px 4px; font-size: 11px; border-radius: 2px;">
                                                    <div style="font-weight: bold; color: #2b6cb0;">⏱️ {{ $totalMinutes }}分</div>
                                                    @foreach ($dayLogs as $log)
                                                        @if($log->memo)
                                                            <div style="color: #4a5568; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $log->memo }}">
                                                                {{ $log->memo }}
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                -->
                                            @endif

                                            @php $currentDay++; @endphp
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            <!-- 【右側】：記録をつけるフォーム ＆ これまでの記録一覧 -->
            <div>
                <!-- 就活記録の入力フォーム -->
                <div class="card">
                    <h3 style="margin-top: 0; border-bottom: 2px solid #edf2f7; padding-bottom: 10px;">⏱️ 記録をつける</h3>
                    <form action="{{ route('study-logs.store') }}" method="POST">
                        @csrf

                        <!-- ==================================================================== -->
                        <!-- 【新しいコード】日付を選ぶ入力欄を追加 -->
                        <!-- ==================================================================== -->
                        <div style="margin-bottom: 12px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px;">日付:</label>
                            <input type="date" name="study_date" value="{{ date('Y-m-d') }}" required style="padding: 8px; width: 100%; box-sizing: border-box; border: 1px solid #cbd5e0; border-radius: 4px;">
                        </div>

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
                    <!-- ==================================================================== -->
                    <!-- 【古いコード】日付入力欄がなかった頃のフォーム -->
                    <!-- ==================================================================== -->
                    <!--
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
                    -->
                </div>

                <!-- これまでの就活記録一覧 -->
                <div class="card">
                    <h3 style="margin-top: 0; border-bottom: 2px solid #edf2f7; padding-bottom: 10px;">📊 これまでの就活記録</h3>
                    
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
【古いコードの保持】：直前まで使っていた初期のシンプルなダッシュボードのコード
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