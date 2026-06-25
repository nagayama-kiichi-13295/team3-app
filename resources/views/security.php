<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログインとセキュリティ</title>
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/security.css">
</head>
<body>
<?= view('header') -> render() ?>
    
    <div class="security-page">
        <div class="card">
            <h1>ログインとセキュリティ</h1>

<?php if (session('status')): ?>
    <p class="status"><?= htmlspecialchars(session('status')) ?></p>
<?php endif; ?>

            <div class="row">
                <div class="row-info">
                    <span class="row-label">パスワード</span>
                    <span class="row-value">・・・・・・・・</span>
                </div>
                <a href="/account/password" class="change-btn">変更</a>
            </div>
            <p class="back"><a href="/account">アカウントサービスに戻る</a></p>
        </div>
    </div>
    <?= view('footer')->render() ?>
</body>
</html>