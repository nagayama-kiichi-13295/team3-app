<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->product_name }}</title>

    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>


<body>

<?= view('header')->render() ?>

<!-- ✅ 通知 -->
<div id="cart-message" class="cart-message" style="display:none;">
    <span id="cart-message-text"></span>
    <a href="/cart" class="view-cart-btn">カートを見る</a>
</div>

<div class="detail-container">

    <!-- 左 -->
    <div class="detail-left">
        <img class="main-image"
             src="{{ asset('storage/' . $product->images->first()->image_path) }}">
    </div>

    <!-- 右 -->
    <div class="detail-right">

        <h1>{{ $product->product_name }}</h1>

        <p class="price">
            ¥{{ number_format($product->price) }}
        </p>

        <p class="description">
            {{ $product->description }}
        </p>

        <!-- ✅ お気に入り -->
        <button id="favBtn" data-id="{{ $product->id }}">
            {{ $isFavorite ? '★ お気に入り済み' : '☆ お気に入り' }}
        </button>

        <!-- ✅ 数量 -->
        <div class="quantity-box">
            <button type="button" id="minusBtn">-</button>
            <input type="number" id="quantity" value="1" min="1">
            <button type="button" id="plusBtn">+</button>
        </div>

        <!-- ✅ ✅ 購入（数量送るようにする） -->
        <form action="{{ route('purchase.form') }}" method="GET">
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" id="buy-quantity" value="1">
            <button type="submit" class="buy-btn">購入する</button>
        </form>

        <!-- ✅ カート -->
        <button class="cart-btn" data-id="{{ $product->id }}">
            カートに追加
        </button>

        <!-- 戻る -->
        <a href="/" class="back-btn">← 一覧へ戻る</a>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    const quantityInput = document.getElementById('quantity');
    const buyQuantity = document.getElementById('buy-quantity');
    const cartBtn = document.querySelector('.cart-btn');
    const favBtn = document.getElementById('favBtn');

    const messageBox = document.getElementById('cart-message');
    const messageText = document.getElementById('cart-message-text');

    // ✅ 数量＋
    document.getElementById('plusBtn').onclick = () => {
        quantityInput.value = parseInt(quantityInput.value) + 1;
        buyQuantity.value = quantityInput.value;
    };

    // ✅ 数量−
    document.getElementById('minusBtn').onclick = () => {
        if (quantityInput.value > 1) {
            quantityInput.value--;
            buyQuantity.value = quantityInput.value;
        }
    };

    // ✅ 手入力対応（重要）
    quantityInput.addEventListener('input', () => {
        let val = parseInt(quantityInput.value) || 1;
        if (val < 1) val = 1;
        quantityInput.value = val;
        buyQuantity.value = val;
    });

    // ✅ カート
    cartBtn.onclick = function() {
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({
                product_id: this.dataset.id,
                quantity: quantityInput.value
            })
        })
        .then(res => {
            if (res.status === 401) {
                location.href = "/login";
                return;
            }
            return res.json();
        })
        .then(data => {
            if (!data) return;

            messageText.innerText = data.message;
            messageBox.style.display = "flex";

            setTimeout(() => {
                messageBox.style.display = "none";
            }, 3000);
        });
    };

    // ✅ お気に入り
    favBtn.onclick = function() {
        fetch('/favorite/toggle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({
                product_id: this.dataset.id
            })
        })
        .then(res => {
            if (res.status === 401) {
                location.href = "/login";
                return;
            }
            return res.json();
        })
        .then(data => {
            if (!data) return;

            favBtn.innerText =
                data.status === 'added'
                ? '★ お気に入り済み'
                : '☆ お気に入り';
        });
    };

});
</script>

</body>
</html>