<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規登録</title>
</head>
<body>

<h1>新規登録</h1>

<form action="/register" method="POST">
    <?= csrf_field() ?>

    名前<br>
    <input type="text" name="name"><br><br>

    メールアドレス<br>
    <input type="email" name="email"><br><br>

    パスワード<br>
    <input type="password" name="password"><br><br>

    <button type="submit">登録</button>

</form>

</body>
</html>