<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>CONFIRM</title>

<link rel="stylesheet" href="/css/Register_result.css">
</head>

<body>

<?= view('header')->render() ?>

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

            <!-- 登録する -->
            <form action="/register/complete" method="POST">
                <?= csrf_field() ?>

                <!-- 値を引き継ぐ -->
                <input type="hidden" name="user_name" value="<?= htmlspecialchars($user_name) ?>">
                <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
                <input type="hidden" name="password" value="<?= htmlspecialchars($password) ?>">

                <button class="submit-btn">登録する</button>
            </form>

            <!-- 戻る -->
            <button class="back-btn" onclick="history.back()">修正する</button>

        </div>

    </div>

</div>

</body>
</html>
