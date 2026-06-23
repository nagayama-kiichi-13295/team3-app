<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>アドレス帳</title>
    <link rel="stylesheet" href="/css/addresses.css">
</head>
<body>
<?= view('header') -> render() ?>
<?php /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Address[] $addresses */ ?>

    <div class="address-page">
        <h1>アドレス帳</h1>

<?php if (session('status')): ?>
        <p class="status"><?= htmlspecialchars(session('status')) ?></p>
<?php endif; ?>

        <div class="address-grid">
<?php foreach($addresses as $address): ?>
            <div class="address-card">
                <div class="card-zip">〒<?= htmlspecialchars($address->postal_code) ?></div>
                <div class="card-addr"><?= htmlspecialchars($address->address) ?></div>
                <div class="card-phone">☎ <?= htmlspecialchars($address->phone_number) ?></div>
                <div class="card-actions">
                    <a href="/account/addresses/<?= $address->id ?>/edit" class="edit-link">編集</a>
                    <form action="/account/addresses/<?= $address->id ?>/delete" method="post"
                            onsubmit="return confirm('この住所を削除しますか？');">
                        <?= csrf_field() ?>
                        <button type="submit" class="delete-link">削除</button>
                    </form>
                </div>
            </div>
<?php endforeach; ?>
        <a href="/account/addresses/create" class="address-card add-card">
            <span class="plus">+</span>
            <span>新しい住所を追加</span>
        </a>
        </div>

        <p class="back"><a href="/account">アカウントサービスに戻る</a></p>
    </div>
    
</body>
</html>