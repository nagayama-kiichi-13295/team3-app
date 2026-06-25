<?php /** @var \App\Models\Address|null $address */ ?>
<?php /** @var \Illuminate\Support\ViewErrorBag $errors */ ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title><?= $address ? '住所を編集' : '住所を追加' ?></title>
    <link rel="stylesheet" href="/css/addresses.css">
</head>
<body>
<?= view('header') -> render() ?>

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
                <div class="zip-row">
                    <input type="text" id="postal_code" name="postal_code" placeholder="123-4567"
                        value="<?= htmlspecialchars(old('postal_code', $address -> postal_code ?? '')) ?>">
                    <button type="button" class="zip-btn" onclick="searchAddress()">住所を自動入力</button>
                </div>
                <small id="zipMsg" class="zip-msg"></small>
            </div>

            <div class="field">
                <label>都道府県</label>
                <input type="text" id="prefecture" name="prefecture" placeholder="サンプル県"
                    value="<?= htmlspecialchars(old('prefecture', '')) ?>">
            </div>

            <div class="field">
                <label>市区町村</label>
                <input type="text" id="city" name="city" placeholder="テスト市ダミー区"
                    value="<?= htmlspecialchars(old('city', '')) ?>">
            </div>

            <div class="field">
                <label>町名・番地</label>
                <input type="text" id="street" name="street" placeholder="架空町1-2-3"
                    value="<?= htmlspecialchars(old('street', '')) ?>">
            </div>

            <div class="field">
                <label>建物名・部屋番号(任意)</label>
                <input type="text" id="building" name="building" placeholder="サンプルハイツ101号"
                    value="<?= htmlspecialchars(old('building', '')) ?>">
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

<script>
    function searchAddress() {
        const zip = document.getElementById('postal_code').value.replace(/[^0-9]/g, '');
        const msg = document.getElementById('zipMsg');

        if (zip.length !== 7) {
            msg.textContent = '郵便番号は7桁で入力してください。';
            return;
        }
        msg.textContent = '検索中...';

        fetch('/api/zipcode?zip=' + zip)
            .then(function (r) { return r.json(); })
            .then(function (d) {
                if (!d.ok) {
                    msg.textContent = d.message || '住所が見つかりませんでした。';
                    return;
                }
                document.getElementById('prefecture').value = d.prefecture;
                document.getElementById('city').value = d.city;
                document.getElementById('street').value = d.town;
                msg.textContent = '';
                document.getElementById('street').focus();
            })
            .catch(function () {
                msg.textContent = '通信エラーが発生しました。';
            });
    }
</script>
    <?= view('footer')->render() ?>
</body>
</html>