<!-- new make -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>入力テスト</title>
</head>
<body>
    <h1>文字入力テスト</h1>
    <!-- 送信先（action）と送信方法（method="POST"）を指定 -->
    <form action="/result" method="POST">
        @csrf <!-- Laravelのお約束のセキュリティトークン -->
        <label for="username">お名前やメッセージ：</label>
        <input type="text" id="username" name="input_text">
        <button type="submit">送信する</button>
    </form>
</body>
</html>