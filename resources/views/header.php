<?php use Illuminate\Support\Facades\Auth; ?>
<?php /** @var \App\Models\User|null $user */ ?>
<?php $user = Auth::user(); ?>

<header>
    <div class="logo">Sneaker Market</div>

    <div class="menu">
        <a href="/">ホーム</a>
<?php if ($user): ?>
        <a href="/mypage">マイページ</a>
        <span><?= htmlspecialchars($user -> name) ?>さん</span>
        <form action="/logout" method="post" style="display:inline;">
            <?= csrf_field() ?>
            <button type="submit">ログアウト</button>
        </form>
<?php else: ?>
        <a href="/login">ログイン</a>
        <a href="/register">新規登録</a>
<?php endif; ?>
    </div>
</header>