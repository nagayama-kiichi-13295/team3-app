<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規登録</title>
</head>
<body>
<?= view('header') -> render() ?>
<?php /** @var \Illuminate\Support\ViewErrorBag $errors */ ?>

<h1>新規登録</h1>

<?php if ($errors -> any()): ?>
    <ul style="color: red;">
<?php foreach ($errors -> all() as $error): ?>
        <li><?= htmlspecialchars($error) ?></li>
<?php endforeach; ?>
    </ul>
<?php endif; ?>


<form action="/register" method="POST">
    <?= csrf_field() ?>

    名前<br>
    <input type="text" name="user_name" value="<?= old('user_name') ?>"><br><br>

    メールアドレス<br>
    <input type="email" name="email" value="<?= old('email') ?>"><br><br>

    パスワード<br>
    <input type="password" name="password"><br><br>

    <button type="submit">登録</button>

</form>

</body>
</html>