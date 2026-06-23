<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>購入完了</title>

    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
</head>

<body>

<?= view('header')->render() ?>

<div class="detail-container">

    <div class="detail-right" style="width:100%; text-align:center;">

        <!-- ✅ タイトル -->
        <h1 style="color:lime;">✅ 購入完了</h1>

        <p style="margin-top:20px;">
            ご購入ありがとうございました！
        </p>

        <!-- ✅ 合計金額 -->
        <p style="font-size:20px; color:red; margin-top:20px;">
            合計金額：¥{{ number_format($total) }}
        </p>

        <hr style="margin:30px 0;">

        <!-- ✅ ボタンエリア -->
        <div style="display:flex; flex-direction:column; gap:10px;">

            <!-- 一覧へ戻る -->
            <a href="/" class="buy-btn" style="text-align:center;">
                商品一覧へ戻る
            </a>

            <!-- カートへ -->
            <a href="/cart" class="cart-btn" style="text-align:center;">
                カートを見る
            </a>

        </div>

    </div>

</div>

</body>
</html>