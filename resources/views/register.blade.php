<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規登録</title>
</head>
<body>
    <h1>新規アカウント作成</h1>

    <form action="/register" method="POST">
        @csrf

        <div>
            <label for="name">ユーザー名：</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
            @error('name')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <br>

        <div>
            <label for="password">パスワード（6文字以上）：</label>
            <input type="password" id="password" name="password">
            @error('password')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <br>

        <button type="submit">登録してログインする</button>
    </form>

    <p style="margin-top: 20px;">
        すでにアカウントをお持ちですか？ <a href="/login">ログインはこちら</a>
    </p>
</body>
</html>