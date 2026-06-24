<?php use Illuminate\Support\Facades\Auth; ?>
<?php /** @var \App\Models\User|null $user */ ?>
<?php $user = Auth::user(); ?>

<link rel="stylesheet" href="/css/header.css">

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
                <?= htmlspecialchars(mb_substr($user -> user_name, 0, 1)) ?>
<?php endif; ?>
            </button>

            <div class="account-menu" id="accountMenu">
                <div class="account-menu-header"><?= htmlspecialchars($user -> user_name) ?>さん</div>
                <a href="/account">アカウントサービス</a>
                <a href="/orders">購入した商品</a>
                <a href="/history">閲覧した商品</a>
                <a href="/contact">お問い合わせ</a>
                <form action="/logout" method="post">
                    <?= csrf_field() ?>
                    <button type="submit" class="logout-btn">ログアウト</button>
                </form>
            </div>
        </div>
<?php else: ?>
        <a href="/login">ログイン</a>
<?php endif; ?>
    </div>
</header>

<script>
    function toggleAccountMenu() {
        document.getElementById("accountMenu").classList.toggle("open");
    }

    // メニューの外側をクリックしたら閉じる
    document.addEventListener("click", function (e) {
        const account = document.querySelector(".account");
        const menu = document.getElementById("accountMenu");
        if (menu && account && !account.contains(e.target)){
            menu.classList.remove("open");
        }
    });
</script>