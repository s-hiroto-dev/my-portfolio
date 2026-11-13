<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>フォームテスト</title>
</head>
<body>
    <h1>文字入力テスト</h1>

    <!-- フォームの送信先を /form に設定（POST送信） -->
    <form action="/form" method="POST">
        @csrf <!-- Laravelのセキュリティ対策（必須） -->

        <!-- 名前入力欄 -->
        <div>
            <label for="name">お名前：</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
            <!-- エラーメッセージ表示 -->
            @error('name')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <br>

        <!-- メールアドレス入力欄 -->
        <div>
            <label for="email">メールアドレス：</label>
            <input type="text" id="email" name="email" value="{{ old('email') }}">
            <!-- エラーメッセージ表示 -->
            @error('email')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <br>

        <button type="submit">送信する</button>
    </form>
</body>
</html>