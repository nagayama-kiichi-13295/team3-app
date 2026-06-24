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

    <!-- ✅ エラー表示 -->
    @if ($errors->any())
        <div class="error-box">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- ✅ ★ここ重要：confirmへ送る -->
    <form action="{{ route('purchase.buyconfirm') }}" method="POST">
        @csrf

        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <!-- ✅ 商品情報 -->
        <p>商品名：{{ $product->product_name }}</p>
        <p>価格：¥{{ number_format($product->price) }}</p>

        <!-- ✅ 数量（追加） -->
        <label>数量</label>
        <input type="number" name="quantity" value="1" min="1" required>

        <!-- ✅ 支払方法（追加） -->
        <label>支払方法</label>
        @if($payments -> isEmpty())
            <div class="no-payment">
                <p>お支払方法が登録されていません。</p>
                <a href="/account/payment/create" target="_blank">お支払方法を追加する</a>
            </div>
        @else
            <div class="payment-select">
                @foreach($payments as $pay)
                    <label class="payment-option">
                        <input type="radio" name="payment_method" required
                            value="{{ $pay->type === 'paypay'
                                ? 'PayPay (***' . substr(preg_replace('/\D/', '', $pay->paypay_phone), -4) . ') '
                                : $pay->card_brand . ' (****' . $pay -> last4 . ') ' }}">
                        
                        @if($pay->type === 'paypay')
                            <span class="pay-badge paypay">PayPay</span>
                            <span>連携番号 ***-****-{{ substr(preg_replace('/\D/', '', $pay->paypay_phone), -4) }}</span>
                        @else
                            <span class="pay-badge card">{{ $pay->card_brand }}</span>
                            <span>・・・・ {{ $pay->last4 }} ({{ sprintf('%02d', $pay->exp_month) }}/{{ $pay->exp_year }}) </span>
                        @endif
                    </label>
                @endforeach
            </div>
        @endif

        <hr>

        <!-- ✅ 住所 -->
        @if(isset($address))

            <div class="saved-address">
                <p>登録済み住所</p>
                <p>{{ $address->postal_code }}</p>
                <p>{{ $address->address }}</p>
                <p>{{ $address->phone_number }}</p>
            </div>

            <!-- ✅ hiddenで送る -->
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

        <button type="submit">確認画面へ</button>

    </form>

</div>

</body>
</html>