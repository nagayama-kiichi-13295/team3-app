<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>購入情報入力</title>

    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
</head>

<body>

<?= view('header')->render() ?>

<div class="form-page">
    <h1 class="form-title">お届け先・お支払いの入力</h1>

    {{-- ✅ 成功メッセージ --}}
    @if(session('success'))
    <div class="success">
        {{ session('success') }}
    </div>
    @endif

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

        <div class="form-layout">

            {{-- 左 --}}
            <div class="form-main">

                {{-- ===== お届け先 ===== --}}{{-- ===== お届け先 ===== --}}
                <section class="form-card">
                    <h2>お届け先</h2>

                    @if(isset($address))

                        <div class="saved-box">
                            <p>〒{{ $address->postal_code }}</p>
                            <p>{{ $address->address }}</p>
                            <p>{{ $address->phone_number }}</p>
                            <span class="saved-tag">登録済み</span>
                        </div>

                        <input type="hidden" name="postal_code" value="{{ $address->postal_code }}">
                        <input type="hidden" name="address" value="{{ $address->address }}">
                        <input type="hidden" name="phone_number" value="{{ $address->phone_number }}">

                    @else

                        <!-- ✅ ✅ 入力フォームは残す -->
                        <div class="field">
                            <label>郵便番号</label>
                            <input type="text" name="postal_code">
                        </div>

                        <div class="field">
                            <label>住所</label>
                            <input type="text" name="address">
                        </div>

                        <div class="field">
                            <label>電話番号</label>
                            <input type="text" name="phone_number">
                        </div>

                        <!-- ✅ ✅ ✅ これが追加ボタン -->
                        <div style="margin-top:10px;">
                            <a href="{{ route('address.create') }}" class="add-address-btn">
                                住所を登録する
                            </a>
                        </div>

                        

                    @endif

                    @if(isset($address))


            <!-- ✅ ✅ ✅ ここ追加 -->
            <div style="margin-top:10px; text-align:right;">
                <a href="{{ route('address.create') }}" class="add-address-btn">
                    ＋住所を追加
                </a>
            </div>

            <input type="hidden" name="postal_code" value="{{ $address->postal_code }}">
            <input type="hidden" name="address" value="{{ $address->address }}">
            <input type="hidden" name="phone_number" value="{{ $address->phone_number }}">

            @endif

                </section>

                {{-- ===== 支払い方法 ===== --}}
                <section class="form-card">
                    <h2>お支払い方法</h2>

                    @if($payments->isEmpty())
                    <p class="no-payment">支払方法が登録されていません。</p>
                    <a href="{{ route('payment.create') }}" class="add-payment-btn">支払方法を追加する</a>
                    @else

                    <div class="payment-select">
                        @foreach($payments as $pay)
                        <label class="payment-option">

                            <input type="radio" name="payment_method" required
                                value="{{ $pay->type === 'paypay' ? 'PayPay' : $pay->card_brand . '（****' . $pay->last4 . '）' }}">

                            @if($pay->type === 'paypay')
                            <span class="pay-badge paypay">PayPay</span>
                            @else
                            <span class="pay-badge card">{{ $pay->card_brand }}</span>
                            <span>****{{ $pay->last4 }}</span>
                            @endif

                        </label>
                        @endforeach
                    </div>

                    @endif
                </section>

            </div>

            {{-- ===== 右 ===== --}}
            <aside class="form-summary">

                <h2>ご注文内容</h2>

                <div class="summary-item">
                    <div class="summary-item-img">

                        @if($product->mainImage && $product->mainImage->image_path)
                        <img src="{{ asset('storage/' . $product->mainImage->image_path) }}">
                        @else
                        <img src="{{ asset('images/no-image.png') }}">
                        @endif

                    </div>

                    <div class="summary-item-info">
                        <p class="summary-item-name">{{ $product->product_name }}</p>
                        <p class="summary-item-price">¥{{ number_format($product->price) }}</p>
                    </div>
                </div>

                <div class="field qty-field">
                    <label>数量</label>
                    <input type="number" name="quantity" id="qtyInput"
                        value="{{ $quantity }}" min="1"
                        data-price="{{ $product->price }}">
                </div>

                <hr>

                <div class="summary-row">
                    <span>小計（<span id="qtyLabel">{{ $quantity }}</span>点）</span>
                    <span id="subtotal">¥{{ number_format($product->price * $quantity) }}</span>
                </div>

                <div class="summary-row">
                    <span>配送料</span>
                    <span>無料</span>
                </div>

                <div class="summary-row summary-total">
                    <span>合計</span>
                    <span id="total">¥{{ number_format($product->price * $quantity) }}</span>
                </div>

                <button type="submit" class="confirm-next-btn">確認画面へ進む</button>

            </aside>

        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const qtyInput = document.getElementById('qtyInput');
    const price = parseInt(qtyInput.dataset.price);

    function yen(n){ return '¥' + n.toLocaleString(); }

    function update(){
        let qty = parseInt(qtyInput.value) || 1;
        if(qty < 1) qty = 1;

        const sum = price * qty;

        document.getElementById('qtyLabel').textContent = qty;
        document.getElementById('subtotal').textContent = yen(sum);
        document.getElementById('total').textContent = yen(sum);
    }

    qtyInput.addEventListener('input', update);
    update();
});
</script>

<?= view('footer')->render() ?>

</body>
</html>