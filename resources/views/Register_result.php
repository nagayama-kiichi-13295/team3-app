<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>登録内容の確認</title>
</head>
<body>
<?= view('header') -> render() ?> <!-- header -->

<?php /** @var string $user_name */ ?>
<?php /** @var string $email */ ?>
<?php /** @var string $password */ ?>

<h1>登録結果</h1>

<p>以下の内容で登録します。これで大丈夫ですか？</p>

<p>名前：<?= htmlspecialchars($user_name) ?></p>
<p>メールアドレス：<?= htmlspecialchars($email) ?></p>

<form action="/register" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="user_name" value="<?= htmlspecialchars($user_name) ?>">
    <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
    <input type="hidden" name="password" value="<?= htmlspecialchars($password) ?>">
    <button type="submit">この内容で登録する</button>
</form>

<form action="/register/back" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="user_name" value="<?= htmlspecialchars($user_name) ?>">
    <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
    <input type="hidden" name="password" value="<?= htmlspecialchars($password) ?>">
    <button type="submit">修正する</button>
</form>
</body>
</html>