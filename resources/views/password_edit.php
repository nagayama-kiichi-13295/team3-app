<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>パスワードの変更</title>
    <link rel="stylesheet" href="/css/security.css">
</head>
<body>
<?=  view('header') -> render() ?>
<?php /** @var \Illuminate\Support\ViewErrorBag $errors */ ?>

<div class="security-page">
    <div class="card">
        <h1>パスワードの変更</h1>
<?php if ($errors -> any()): ?>
        <ul class="error">
<?php foreach ($errors -> all() as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
<?php endforeach; ?>
        </ul>
<?php endif; ?>

        <form action="/account/password" method="post">
            <?= csrf_field() ?>

            <div class="field">
                <label>現在のパスワード</label>
                <input type="password" name="current_password" class="pw-input">
            </div>
            
            <div class="field">
                <label>新しいパスワード</label>
                <input type="password" name="new_password" class="pw-input">
                <small>8文字以上</small>
            </div>
            
            <div class="field">
                <label>新しいパスワード(確認用)</label>
                <input type="password" name="new_password_confirmation" class="pw-input">
                <small>8文字以上</small>
            </div>

            <label class="show-toggle">
                <input type="checkbox" onclick="togglePw(this)">パスワード表示
            </label>

            <button type="submit">変更する</button>
        </form>

        <p class="back"><a href="/account/security">戻る</a></p>
    </div>
</div>

<script>
    function togglePw(checkbox) {
        const type =checkbox.checked ? 'text' : 'password';
        document.querySelectorAll('.pw-input').forEach(function(input) {
            input.type = type;
        });
    }
</script>
<?= view('footer')->render() ?>
</body>
</html>