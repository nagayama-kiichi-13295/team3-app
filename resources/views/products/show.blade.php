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

</body>
</html>