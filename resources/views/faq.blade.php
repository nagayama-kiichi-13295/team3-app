<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>よくある質問</title>
</head>
<link rel="stylesheet" href="/css/header.css">
<link rel="stylesheet" href="/css/faq.css">
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

                <form action="/logout" method="POST">
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
<div class="container">
  <h1>よくある質問</h1>

    <h2>FAQ</h2>

    @foreach($faqs as $faq)
        <div class="faq-item">
            <h3>Q. {{ $faq->keyword }}</h3>
            <p>A. {{ $faq->answer }}</p>
        </div>
    @endforeach


    <h2>お問い合わせの回答</h2>

    @foreach($contacts as $contact)
        <div class="faq-item">
            <h3>Q. {{ $contact->message }}</h3>
            <p>A. {{ $contact->answer }}</p>
        </div>
    @endforeach


</div>
<script>
function toggleAccountMenu() {
    document.getElementById('accountMenu').classList.toggle('open');
}
</script>
</body>
</html>