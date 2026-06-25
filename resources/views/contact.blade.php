<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お問い合わせ</title>

    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/contacts.css">
</head>

<body>

<?php use Illuminate\Support\Facades\Auth; ?>
<?php $user = Auth::user(); ?>

<header>
    <a href="/" class="logo">
        <img src="/images/logo.png" class="logo-img">
        <span>Sneaker Market</span>
    </a>

    <div class="menu">
        <a href="/">ホーム</a>
        <a href="/cart">カート🛒</a>

<?php if ($user): ?>
        <div class="account">
            <button class="account-icon" onclick="toggleAccountMenu()">
<?php if (!empty($user->icon_path)): ?>
                <img src="<?= asset('storage/' . $user->icon_path) ?>">
<?php else: ?>
                <?= htmlspecialchars(mb_substr($user->user_name, 0, 1)) ?>
<?php endif; ?>
            </button>

            <div class="account-menu" id="accountMenu">
                <div class="account-menu-header">
                    <?= htmlspecialchars($user->user_name) ?>さん
                </div>

                <a href="/account">アカウント</a>
                <a href="/orders">購入履歴</a>
                <a href="/history">閲覧履歴</a>
                <a href="/contact">お問い合わせ</a>
                <a href="/faq">よくある質問</a>

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


<!-- ✅ ========= 本体（スニダン風） ========= -->
<div class="contact-wrapper">

    <h1>お問い合わせ</h1>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contact.send') }}" method="POST" class="contact-form">
        @csrf

        <div class="form-group">
            <label>名前</label>
            <input type="text" name="name" value="{{ old('name') }}">
        </div>

        <div class="form-group">
            <label>メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label>お問い合わせ内容</label>
            <textarea name="message">{{ old('message') }}</textarea>
        </div>

        <button type="submit" class="send-btn">
            送信する
        </button>
    </form>

</div>


<script>
function toggleAccountMenu() {
    document.getElementById("accountMenu").classList.toggle("open");
}

document.addEventListener("click", function(e) {
    const account = document.querySelector(".account");
    const menu = document.getElementById("accountMenu");

    if (menu && account && !account.contains(e.target)) {
        menu.classList.remove("open");
    }
});
</script>
@if(isset($faqAnswer))
<div class="faq-box">
    <h3>参考回答</h3>
    <p>{{ $faqAnswer->answer }}</p>
</div>
@endif
<?= view('footer')->render() ?>
</body>
</html>