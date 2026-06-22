<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>CONFIRM</title>
    <link rel="stylesheet" href="/css/Register_result.css">
</head>
<body>
<?= view('header')->render() ?>
<?php /** @var string $user_name */ ?>
<?php /** @var string $email */ ?>
<?php /** @var string $password */ ?>

    <div class="confirm-wrapper">
        <div class="confirm-box">
            <h1>CONFIRM</h1>
            <p class="sub">入力内容をご確認ください</p>

            <!-- 名前 -->
            <div class="confirm-item">
                <span>USERNAME</span>
                <p><?= htmlspecialchars($user_name) ?></p>
            </div>

            <!-- メール -->
            <div class="confirm-item">
                <span>EMAIL</span>
                <p><?= htmlspecialchars($email) ?></p>
            </div>

            <!-- ボタン -->
            <div class="btn-group">

                <!-- 登録する：POST /register でユーザーを保存（←元の機能を維持） -->
                <form action="/register" method="post">
                <?= csrf_field() ?>
                    <input type="hidden" name="user_name" value="<?= htmlspecialchars($user_name) ?>">
                    <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
                    <input type="hidden" name="password" value="<?= htmlspecialchars($password) ?>">
                    <button class="submit-btn">登録する</button>
                </form>

                <!-- 修正する：POST /register/back で入力を保持して登録フォームへ戻る（←元の機能を維持） -->
                <form action="/register/back" method="post">
                <?= csrf_field() ?>
                    <input type="hidden" name="user_name" value="<?= htmlspecialchars($user_name) ?>">
                    <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
                    <input type="hidden" name="password" value="<?= htmlspecialchars($password) ?>">
                    <button class="back-btn">修正する</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>