<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ショッピングカート</title> 
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
</head>

<body>
<?= view('header')->render() ?>

<div class="cart-container">
    <h1>ショッピングカート</h1>

    @if(empty($cartItems) || count($cartItems) == 0)
        <div class="empty-cart">
            <p>カートに商品が入っていません。</p>
            <a href="/" class="back-btn">← 商品一覧に戻る</a>
        </div>
    @else
        <div class="cart-content">
            <div class="cart-items" style="border-bottom: 1px solid #ddd; padding-bottom: 20 px; margin-bottom: 20px;">
                @foreach($cartItems as $item)
                <div class="cart-item">

                    <div class="item-image">
                        @if($item['product']->mainImage && $item['product']->mainImage->image_path)
                            <img src="{{ asset('storage/' . $item['product']->mainImage->image_path) }}" alt="{{ $item['product']->name }}" style="width: 200px; height: 200px; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/no-image.png') }}" alt="No Image" style="width: 100px; height: 100px; object-fit: cover;">
                        @endif
                    </div>

                    <div class="item-details">
                        <h3>{{ $item['product']->product_name }}</h3>
                        <p class="item-price">{{ number_format($item['product']->price) }}円</p>
                    </div>

                    <div class="item-actions">
                        <!-- 数量更新 -->
                        <form action="{{ route('cart.update', $item['product']->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1">
                            <button type="submit" class="btn-update">更新</button>
                        </form>

                        <!-- 削除 -->
                        <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('削除しますか？')">削除</button>
                        </form>
                    </div>

                </div>
                @endforeach
            </div>

            <!-- ✅ 注文内容 -->
            <div class="cart-summary">
               
                <h2>注文内容</h2>

                <div class="summary-row">
                    <span>小計</span>
                    <span>{{ number_format($totalPrice) }}円</span>
                </div>

                <div class="summary-row theme-total">
                    <span>合計金額 (税込)</span>
                    <span class="total-price">{{ number_format($totalPrice) }}円</span>
                </div>

                <!-- ✅ ここが重要（修正ポイント） -->
                @if(!empty($cartItems))
                    <a href="/purchase/form?product_id={{ $cartItems[0]['product']->id }}" class="btn-checkout">
                        購入手続きへ進む
                    </a>
                @endif

                <a href="/" class="btn-continue">ショッピングを続ける</a>

            </div>

        </div>
    @endif
</div>

</body>
</html>