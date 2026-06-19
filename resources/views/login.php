<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="/css/login.css">
</head>
<body>

<?= view('header') -> render() ?>
<?php /** @var \Illuminate\Support\ViewErrorBag $errors */ ?>
    
<h2>ログイン</h2>

<form action="/login" method="post">
    <?= csrf_field() ?>
    メールアドレス: <input type="email" name="email" value="<?= old('email') ?>"><br>
    パスワード: <input type="password" name="password"><br>
    <button type="submit">ログイン</button>
</form>

<?php if ($errors -> any()): ?>
    <p style="color: red;"><?= $errors -> first() ?></p>
<?php endif; ?>

<p>アカウントお持ちでない方は<a href="/register">新規登録はこちら</a></p>

</body>
</html>