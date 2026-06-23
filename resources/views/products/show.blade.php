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

    <!-- ✅ 左：画像 -->
    <div class="detail-left">
        <img class="main-image"
             src="{{ asset('storage/' . $product->images->first()->image_path) }}">
    </div>

    <!-- ✅ 右：情報 -->
    <div class="detail-right">

        <h1>{{ $product->product_name }}</h1>

        <p class="price">
            ¥{{ number_format($product->price) }}
        </p>

        <p class="description">
            {{ $product->description }}
        </p>

        <!-- ✅ 数量UI -->
        <div class="quantity-box">
            <button type="button" id="minusBtn">-</button>

            <input type="number" id="quantity" value="1" min="1">

            <button type="button" id="plusBtn">+</button>
        </div>

        <!-- ✅ 購入 -->
        <form action="/purchase/form" method="get">
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <button class="buy-btn">購入する</button>
        </form>

        <!-- ✅ カート追加 -->
        <button class="cart-btn" data-product-id="{{ $product->id }}">
            カートに追加
        </button>

        <!-- ✅ 戻る -->
        <a href="/" class="back-btn">← 一覧へ戻る</a>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const minusBtn = document.getElementById('minusBtn');
    const plusBtn = document.getElementById('plusBtn');
    const quantityInput = document.getElementById('quantity');
    const cartBtn = document.querySelector('.cart-btn');

    const messageBox = document.getElementById('cart-message');
    const messageText = document.getElementById('cart-message-text');

    // ✅ マイナス
    minusBtn.addEventListener('click', () => {
        let current = parseInt(quantityInput.value);
        if (current > 1) {
            quantityInput.value = current - 1;
        }
    });

    // ✅ プラス
    plusBtn.addEventListener('click', () => {
        let current = parseInt(quantityInput.value);
        quantityInput.value = current + 1;
    });

    // ✅ カート追加
    cartBtn.addEventListener('click', function() {

        const productId = this.getAttribute('data-product-id');
        const quantity = quantityInput.value;

        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute('content');

        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => {

            // ✅ 未ログインならログイン画面へ
            if (response.status === 401) {
                window.location.href = "/login";
                return;
            }

            return response.json();
        })
        .then(data => {
            if (data && data.success) {

                // ✅ 通知表示
                messageText.innerText = data.message;
                messageBox.style.display = 'flex';

                setTimeout(() => {
                    messageBox.style.display = 'none';
                }, 3000);
            }
        })
        .catch(error => {
            console.error(error);
            alert('カート追加に失敗しました');
        });

    });

});
</script>

</body>
</html>