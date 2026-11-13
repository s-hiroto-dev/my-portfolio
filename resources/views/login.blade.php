<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
</head>
<body>
    <h1>ログイン画面</h1>

    <!-- ログインフォームの送信先を /login に設定（POST送信） -->
    <form action="/login" method="POST">
        @csrf <!-- Laravelのセキュリティ対策（必須） -->

        <!-- ユーザー名入力欄 -->
        <div>
            <label for="name">ユーザー名：</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
            <!-- エラーメッセージ表示 -->
            @error('name')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <br>

        <!-- パスワード入力欄 -->
        <div>
            <label for="password">パスワード：</label>
            <input type="password" id="password" name="password">
            <!-- エラーメッセージ表示 -->
            @error('password')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <br>

        <button type="submit">ログインする</button>
    </form>
</body>
</html>