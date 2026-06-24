<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>購入確認</title>
    <link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
</head>

<body>

<?= view('header')->render() ?>

<div class="detail-container">

    <div class="confirm-box">

        <h1>購入確認</h1>

        <hr>

        <!-- ✅ 商品情報 -->
        <h3>商品情報</h3>

        <p>商品名：{{ $product->product_name }}</p>
        <p>価格：¥{{ number_format($product->price) }}</p>
        <p>数量：{{ $quantity }}</p>

        <p class="total">
            小計：¥{{ number_format($product->price * $quantity) }}
        </p>

        <hr>

        <!-- ✅ 合計 -->
        <p class="total">
            合計金額：¥{{ number_format($total) }}
        </p>

        <hr>

        <!-- ✅ お届け先 -->
        <h3>お届け先</h3>
        <p>郵便番号：{{ $data['postal_code'] }}</p>
        <p>住所：{{ $data['address'] }}</p>
        <p>電話番号：{{ $data['phone_number'] }}</p>

        <hr>

        <!-- ✅ 支払方法 -->
        <h3>支払方法</h3>
        <p>{{ $data['payment_method'] }}</p>

        <hr>

        <!-- ✅ 購入 -->
        <form action="{{ route('purchase.complete') }}" method="POST">
            @csrf

            <!-- ✅ hiddenで全部渡す -->
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="{{ $quantity }}">
            <input type="hidden" name="postal_code" value="{{ $data['postal_code'] }}">
            <input type="hidden" name="address" value="{{ $data['address'] }}">
            <input type="hidden" name="phone_number" value="{{ $data['phone_number'] }}">
            <input type="hidden" name="payment_method" value="{{ $data['payment_method'] }}">

            <button class="buy-btn">購入する</button>
        </form>

        <!-- ✅ 戻る -->
        <button onclick="history.back()" class="back-btn">
            戻る
        </button>

    </div>

</div>

</body>
</html>
