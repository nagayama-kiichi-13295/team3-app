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

<!-- ✅ 通知エリア -->
<div id="cart-message" class="cart-message" style="display:none;">
    <span id="cart-message-text"></span>
    <a href="/cart" class="view-cart-btn">カートを見る</a>
</div>

<div class="detail-container">

    <!-- 左：画像 -->
    <div class="detail-left">
        <img class="main-image"
             src="{{ asset('storage/' . $product->images->first()->image_path) }}">
    </div>

    <!-- 右：情報 -->
    <div class="detail-right">

        <h1>{{ $product->product_name }}</h1>

        <p class="price">
            ¥{{ number_format($product->price) }}
        </p>

        <p class="description">
            {{ $product->description }}
        </p>

        <!-- 購入ボタン -->
        <form action="/purchase/form" method="get">
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <button class="buy-btn">購入する</button>
        </form>

        <!-- ✅ カート追加ボタン -->
        <button class="cart-btn" data-product-id="{{ $product->id }}">
            カートに追加
        </button>

        <!-- 戻る -->
        <a href="/" class="back-btn">← 一覧へ戻る</a>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const cartBtn = document.querySelector('.cart-btn');
    const messageBox = document.getElementById('cart-message');
    const messageText = document.getElementById('cart-message-text');

    if (cartBtn) {
        cartBtn.addEventListener('click', function() {

            const productId = this.getAttribute('data-product-id');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('通信エラー');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // ✅ 通知表示
                    messageText.innerText = data.message;
                    messageBox.style.display = 'flex';

                    // ✅ 3秒後に自動で消える
                    setTimeout(() => {
                        messageBox.style.display = 'none';
                    }, 3000);
                }
            })
            .catch(error => {
                console.error(error);
                alert('カート追加失敗');
            });

        });
    }
});
</script>

</body>
</html>