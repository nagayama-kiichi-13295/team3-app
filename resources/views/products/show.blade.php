<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>商品詳細</title>

<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
</head>

<body>

<?= view('header') -> render() ?>


<div class="detail-container">

    <!-- 商品名 -->
    <h1 class="detail-title">
        {{ $product->product_name }}
    </h1>

    <!-- 画像 -->
    <div class="image-list">
        @foreach($product->images as $image)
            <img src="{{ asset('storage/' . $image->image_path) }}" alt="">
        @endforeach
    </div>

    <!-- 価格 -->
    <p class="detail-price">
        {{ number_format($product->price) }}円
    </p>

    <!-- 説明 -->
    @if($product->description)
        <p class="detail-description">
            {{ $product->description }}
        </p>
    @endif

    <!-- 戻る -->
    <a href="/" class="back-btn">← 戻る</a>

</div>

</body>
</html>