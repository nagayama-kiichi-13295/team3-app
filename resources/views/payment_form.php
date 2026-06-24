<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お支払方法を追加</title>
    <link rel="stylesheet" href="/css/payment.css">
</head>
<body>
<?= view('header')->render() ?>
<?php /** @var \Illuminate\Support\ViewErrorBag $errors */ ?>

<div class="payment--page">
    <div class="form-card">
        <h1>お支払方法を追加</h1>

<?php if ($errors->any()): ?>
        <ul class="error">
<?php foreach ($errors->all() as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
<?php endforeach; ?>
        </ul>
<?php endif; ?>

        <form action="/account/payment" method="post">
            <?= csrf_field() ?>

            <div class="field">
                <label>お支払方法の種類</label>
                <select name="type" id="type" onchange="onTypeChange()">
                    <option value="card" <?= old('type') === 'paypay' ? '' : 'selected' ?>>クレジットカード</option>
                    <option value="paypay" <?= old('type') === 'paypay' ? '' : 'selected' ?>>PayPay</option>
                </select>
            </div>

            <!-- カード用 -->
             <div class="cardFields">
                <div class="field">
                    <label>カードブランド</label>
                    <select name="card_brand">
                        <option value="">選択してください</option>
                        <option value="VISA" <?= old('card_brand') === 'VISA' ? 'selected' : '' ?>>VISA</option>
                        <option value="Mastercard" <?= old('card_brand') === 'Mastercard' ? 'selected' : '' ?>>Mastercard</option>
                        <option value="JCB" <?= old('card_brand') === 'JCB' ? 'selected' : '' ?>>JCB</option>
                        <option value="AMEX" <?= old('card_brand') === 'AMEX' ? 'selected' : '' ?>>AMEX</option>
                        <option value="その他" <?= old('card_brand') === 'その他' ? 'selected' : '' ?>>その他</option>
                    </select>
                </div>
                <div class="field">
                    <label>カード番号</label>
                    <input type="text" name="card_number" placeholder="1234 5678 9012 3456"
                        value="<?= htmlspecialchars(old('card_number') ?? '') ?>">
                    <small>※ 下4桁のみ保存されます</small>
                </div>
                <div class="field">
                    <label>名義</label>
                    <input type="text" name="card_holder" placeholder="TARO YAMADA"
                        value="<?= htmlspecialchars(old('card_holder') ?? '') ?>">
                </div>
                <div class="field-row">
                    <div class="field">
                        <label>有効期限(月)</label>
                        <input type="number" name="exp_month" placeholder="12" min="1" max="12"
                            value="<?= htmlspecialchars(old('exp_month') ?? '') ?>">
                    </div>
                    <div class="field">
                        <label>有効期限(年)</label>
                        <input type="number" name="exp_year" placeholder="2028" min="<?= date('Y') ?>"
                            value="<?= htmlspecialchars(old('exp_year') ?? '') ?>">
                    </div>
                </div>
             </div>

             <!-- PayPay用 --->
              <div id="paypayFields" style="display: none;">
                <div class="field">
                    <label>PayPayの登録電話番号</label>
                    <input type="text" name="paypay_phone" placeholder="090-1234-5678"
                        value="<?= htmlspecialchars(old('paypay_phone') ?? '') ?>">
                    <small>※ 連携番号として下4桁を表示します</small>
                </div>
              </div>

              <button type="submit">追加する</button>
        </form>

        <p class="back"><a href="/account/payment">戻る</a></p>
    </div>
</div>

<script>
    function onTypeChange() {
        const type = document.getElementById('type').value;
        document.getElementById('cardField').style.display = (type === 'card') ? 'block' : 'none';
        document.getElementById('paypayField').style.display = (type === 'paypay') ? 'block' : 'none';
    }
    onTypeChange();
</script>
</body>
</html>