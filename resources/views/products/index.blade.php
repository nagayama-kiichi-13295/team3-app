<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>スニーカー販売サイト</title>

<!-- ✅ CSS読み込み（ここが正解） -->
<link rel="stylesheet" href="{{ asset('css/home.css') }}">

</head>
<body>

<header>
    <div class="logo">Sneaker Market</div>

    <div class="menu">
        <a href="/">ホーム</a>
        <a href="/login">ログイン</a>
        <a href="/register">新規登録</a>
        <a href="/mypage">マイページ</a>
    </div>
</header>

<div class="search-area">
    <input type="text" placeholder="商品名を検索">
</div>

<div class="banner">
    <h1>人気スニーカー特集</h1>
    <p>限定モデル続々入荷中！</p>
</div>

<div class="product-list">

@foreach($products as $product)

<a href="{{ route('products.show', $product->id) }}" style="text-decoration:none;color:black;">

    <div class="card">

        <div class="image">
            @if($product->mainImage)
                <img src="{{ asset('storage/' . $product->mainImage->image_path) }}"
                     style="width:100%; height:100%; object-fit:cover;">
            @else
                <img src="/images/no-image.png"
                     style="width:100%; height:100%; object-fit:cover;">
            @endif
        </div>

        <div class="card-body">
            <h3>{{ $product->name }}</h3>

            <div class="price">
                {{ number_format($product->price) }}円
            </div>
        </div>

    </div>

</a>

@endforeach

</div>

</body>
</html>