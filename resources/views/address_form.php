<?php /** @var \App\Models\Address|null $address */ ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title><?= $address ? '住所を編集' : '住所を追加' ?></title>
    <link rel="stylesheet" href="/css/addresses.css">
</head>
<body>
<?= view('header') -> render() ?>
<?php /** @var \App\Models\Address|null $address */ ?>
<?php /** @var \Illuminate\Support\ViewErrorBag $errors */ ?>

<div class="address-page">
    <div class="form-card">
        <h1><?= $address ? '住所を編集' : '住所を追加' ?></h1>
<?php if ($errors->any()): ?>
        <ul class="error">
<?php foreach ($errors -> all() as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
<?php endforeach; ?>
        </ul>
<?php endif; ?>
        <form action="<?= $address ? '/account/addresses/' . $address->id : '/account/addresses' ?>" method="post">
            <?= csrf_field() ?>

            <div class="field">
                <label>郵便番号</label>
                <input type="text" name="postal_code" placeholder="000-0000"
                    value="<?= htmlspecialchars(old('postal_code', $address -> postal_code ?? '')) ?>">
            </div>

            <div class="field">
                <label>住所</label>
                <input type="text" name="address" placeholder="住所(~県~市~区~0-0-0)"
                    value="<?= htmlspecialchars(old('address', $address -> address ?? '')) ?>">
            </div>

            <div class="field">
                <label>電話番号</label>
                <input type="text" name="phone_number" placeholder="090-1234-5678"
                    value="<?= htmlspecialchars(old('phone_number', $address -> phone_number ?? '')) ?>">
            </div>

            <button type="submit"><?= $address ? '更新する' : '追加する' ?></button>
        </form>

        <p class="back"><a href="/account/addresses">戻る</a></p>
    </div>
</div>
    
</body>
</html>