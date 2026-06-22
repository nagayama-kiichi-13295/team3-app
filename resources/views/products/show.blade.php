<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>{{ $product->product_name }}</title>

<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
</head>

<body>

<?= view('header')->render() ?>

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

        <!-- 戻る -->
        <a href="/" class="back-btn">← 一覧へ戻る</a>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cartBtn = document.querySelector('.cart-btn');

    if (cartBtn) {
        cartBtn.addEventListener('click', function() {
            // ボタンから商品IDを取得
            const productId = this.getAttribute('data-product-id');
            // MetaタグからCSRFトークンを取得
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // 画面をリロードせずに、裏側で '/cart/add' にPOST送信（Fetch API）
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
                    throw new Error('通信エラーが発生しました');
                }
                return response.json();
            })
            .then(data => {
                // web.phpから成功のJSONが返ってきた時の処理
                if (data.success) {
                    alert(data.message); // 「カートに追加しました！」と表示されます
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('カートへの追加に失敗しました。');
            });
        });
    }
});
</script>

</body>
</html>