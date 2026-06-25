<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お問い合わせ完了</title>
</head>
<body>
    <?php use Illuminate\Support\Facades\Auth; ?>
<?php $user = Auth::user(); ?>
<header>
    <a href="/" class="logo">
        <img src="/images/logo.png" alt="Sneaker Market" class="logo-img">
        <span>Sneaker Market</span>
    </a>

    <div class="menu">
        <a href="/">ホーム</a>
        <a href="/cart">カート🛒</a>

<?php if ($user): ?>
        <div class="account">
            <button class="account-icon" onclick="toggleAccountMenu()" aria-label="アカウントメニュー">
<?php if (!empty($user->icon_path)): ?>
                <img src="<?= asset('storage/' . $user->icon_path) ?>" alt="アイコン">
<?php else: ?>
                <?= htmlspecialchars(mb_substr($user->user_name, 0, 1)) ?>
<?php endif; ?>
            </button>

            <div class="account-menu" id="accountMenu">
                <div class="account-menu-header">
                    <?= htmlspecialchars($user->user_name) ?>さん
                </div>

                <a href="/account">アカウントサービス</a>
                <a href="/orders">購入した商品</a>
                <a href="/history">閲覧した商品</a>
                <a href="/contact">お問い合わせ</a>

               <form action="{{ route('contact.confirm') }}" method="POST">
                    <?= csrf_field() ?>
                    <button type="submit" class="logout-btn">
                        ログアウト
                    </button>
                </form>
            </div>
        </div>
<?php else: ?>
        <a href="/login">ログイン</a>
<?php endif; ?>
    </div>
</header>
<h1>お問い合わせ完了</h1>

<p>送信を受け付けました。</p>



</body>
</html>