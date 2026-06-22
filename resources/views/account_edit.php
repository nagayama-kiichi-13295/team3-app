<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>アカウント情報変更</title>
    <link rel="stylesheet" href="/css/account.css">
</head>
<body>
<?= view('header') -> render() ?>
<?php /** @var \App\Models\User $user */ ?>
<?php /** @var \Illuminate\Support\ViewErrorBag $errors */ ?>

<div class="account-page">
    <div class="card">
        <h1>アカウント情報変更</h1>
<?php if (session('status')): ?>
        <p class="status"><?= htmlspecialchars(session('status')) ?></p>
<?php endif; ?>

<?php if ($errors -> any()): ?>
        <ul class="error">
<?php foreach ($errors -> all() as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
<?php endforeach; ?>
        </ul>
<?php endif; ?>
        
        <form action="/account/update" method="post">
            <?= csrf_field() ?>

            <div class="field">
                <label>名前</label>
                <input type="text" name="user_name"
                    value="<?= htmlspecialchars(old('user_name', $user -> user_name)) ?>">
            </div>

            <div class="field">
                <label>メールアドレス</label>
                <input type="email" name="email"
                    value="<?= htmlspecialchars(old('email', $user -> email)) ?>">
            </div>

            <button type="submit">更新する</button>
        </form>

        <p class="back"><a href="/mypage">マイページに戻る</a></p>
    </div>
</div>

</body>
</html>