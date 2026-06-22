<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>商品詳細</title>

<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
</head>

<body>

<?= view('header') -> render() ?>

<div class="detail-container">

    <h1 class="detail-title">
        {{ $product->product_name }}
    </h1>

    <div class="image-list">
        @foreach($product->images as $image)
            <img src="{{ asset('storage/' . $image->image_path) }}" alt="">
        @endforeach
    </div>

    <p class="detail-price">
        {{ number_format($product->price) }}円
    </p>

    @if($product->description)
        <p class="detail-description">
            {{ $product->description }}
        </p>
    @endif

    <button type="button" class="cart-btn" data-product-id="{{ $product->id }}">
        カートに追加
    </button>

    <a href="/" class="back-btn">← 戻る</a>

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