<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>購入確認</title>
    <link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
</head>

<body>

    <?= view('header')->render() ?>

    <div class="confirm-page">
        <h1 class="confirm-title">ご注文内容の確認</h1>
        <div class="confirm-layout">
            {{-- 左：詳細セクション --}}
            <div class="confirm-main">
                <section class="confirm-card">
                    <h2>お届け先</h2>
                    <p>〒{{ $data['postal_code'] }}</p>
                    <p>{{ $data['address'] }}</p>
                    <p>{{ $data['phone_number'] }}</p>
                </section>
                <section class="confirm-card">
                    <h2>お支払い方法</h2>
                    <p>{{ $data['payment_method'] }}</p>
                </section>
                <section class="confirm-card">
                    <h2>注文商品</h2>
                    <div class="confirm-item">
                        <div class="confirm-item-img">
                            @if($product->mainImage && $product->mainImage->image_path)
                            <img src="{{ asset('storage/' . $product->mainImage->image_path) }}" alt="{{ $product->product_name }}">
                            @else
                            <img src="{{ asset('images/no-image.png') }}" alt="">
                            @endif
                        </div>
                        <div class="confirm-item-info">
                            <p class="confirm-item-name">{{ $product->product_name }}</p>
                            <p class="confirm-item-qty">数量：{{ $quantity }}</p>
                            <p class="confirm-item-price">¥{{ number_format($product->price) }}</p>
                        </div>
                    </div>
                </section>
            </div>
            {{-- 右：注文サマリー --}}
            <aside class="confirm-summary">
                <h2>注文サマリー</h2>
                <div class="summary-row">
                    <span>小計（{{ $quantity }}点）</span>
                    <span>¥{{ number_format($product->price * $quantity) }}</span>
                </div>
                <div class="summary-row">
                    <span>配送料</span>
                    <span>無料</span>
                </div>
                <hr>
                <div class="summary-row summary-total">
                    <span>合計</span>
                    <span>¥{{ number_format($total) }}</span>
                </div>
                <form action="{{ route('purchase.complete') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="{{ $quantity }}">
                    <input type="hidden" name="postal_code" value="{{ $data['postal_code'] }}">
                    <input type="hidden" name="address" value="{{ $data['address'] }}">
                    <input type="hidden" name="phone_number" value="{{ $data['phone_number'] }}">
                    <input type="hidden" name="payment_method" value="{{ $data['payment_method'] }}">
                    <button class="confirm-buy-btn">注文を確定する</button>
                </form>
                <button onclick="history.back()" class="confirm-back-btn">戻る</button>
            </aside>
        </div>
    </div>

    <?= view('footer')->render() ?>

</body>

</html>