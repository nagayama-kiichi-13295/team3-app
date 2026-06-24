<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お客様のお支払方法</title>
    <link rel="stylesheet" href="/css/payment.css">
</head>
<body>
<?= view('header')->render() ?>
<?php /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\PaymentMethod[] $methods */ ?>

<div class="payment-page">
    <h1>お客さまのお支払い方法</h1>

<?php if (session('status')): ?>
    <p class="status"><?= htmlspecialchars(session('status')) ?></p>
<?php endif; ?>
    
    <div class="payment-grid">

<?php foreach ($methods as $method): ?>
        <div class="pay-cell">
<?php if ($method->type === 'paypay'): ?>
            <div class="pay-card paypay">
                <div class="pay-logo">PayPay</div>
                <div class="pay-number">連携番号 ***-****-<?= htmlspecialchars(substr(preg_replace('/\D/', '', $method->paypay_phone), -4)) ?></div>
                <div class="pay-bottom"><span>PayPay残高</span><span>連携済み</span></div>
            </div>
<?php else: ?>
            <div class="pay-card"> 
                <div class="pay-brand"><?= htmlspecialchars($method->card_brand) ?></div>
                <div class="pay-number">・・・・ ・・・・ ・・・・<?= htmlspecialchars($method->last4) ?></div>
                <div class="pay-bottom">
                    <span><?= htmlspecialchars($method->card_holder) ?></span>
                    <span><?= sprintf('%02d', $method->exp_month) ?>/<?= htmlspecialchars($method->exp_year) ?></span>
                </div>
            </div>
<?php endif; ?>
            <form action="/account/payment/<?= $method->id ?>/delete" method="post"
                onsubmit="return confirm('このお支払方法を削除しますか？');">
                <?= csrf_field() ?>
                <button type="submit" class="pay-delete">削除</button>
            </form>
        </div>
<?php endforeach; ?>

        <a href="/account/payment/create" class="pay-cell add-card">
            <span class="plus">+</span>
            <span>お支払方法を追加</span>
        </a>
    </div>

    <p class="back"><a href="/account">アカウントサービスに戻る</a></p>
</div>
</body>
</html>