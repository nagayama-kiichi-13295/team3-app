<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>購入情報入力</title>

<link rel="stylesheet" href="{{ asset('css/form.css') }}">
</head>

<body>

<?= view('header')->render() ?>

<div class="form-container">

    <h2>購入情報入力</h2>

    <!-- エラー -->
    @if ($errors->any())
        <div class="error-box">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('purchase.buyconfirm') }}" method="POST">
        @csrf

        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <!-- ✅ 商品情報 -->
        <p>商品名：{{ $product->product_name }}</p>
        <p>価格：¥{{ number_format($product->price) }}</p>

        <!-- ✅ 数量 -->
        <label>数量</label>
        <input type="number" name="quantity" value="{{ $quantity }}" min="1" required>

        <!-- ✅ 支払方法 -->
        <label>支払方法</label>

        @if($payments->isEmpty())
            <p>支払方法がありません</p>
        @else
            @foreach($payments as $pay)
                <label>
                    <input type="radio" name="payment_method" required
                        value="{{ $pay->type === 'paypay'
                            ? 'PayPay'
                            : $pay->card_brand }}">
                    
                    @if($pay->type === 'paypay')
                        PayPay
                    @else
                        {{ $pay->card_brand }}（****{{ $pay->last4 }}）
                    @endif
                </label>
            @endforeach
        @endif

        <hr>

        <!-- ✅ 住所 -->
        @if(isset($address))

            <p>郵便番号：{{ $address->postal_code }}</p>
            <p>住所：{{ $address->address }}</p>
            <p>電話番号：{{ $address->phone_number }}</p>

            <input type="hidden" name="postal_code" value="{{ $address->postal_code }}">
            <input type="hidden" name="address" value="{{ $address->address }}">
            <input type="hidden" name="phone_number" value="{{ $address->phone_number }}">

        @else

            <label>郵便番号</label>
            <input type="text" name="postal_code" required>

            <label>住所</label>
            <input type="text" name="address" required>

            <label>電話番号</label>
            <input type="text" name="phone_number" required>

        @endif

        <!-- ✅ ボタン -->
        <button type="submit">確認画面へ</button>

    </form>

</div>
<?= view('footer')->render() ?>
</body>
</html>
