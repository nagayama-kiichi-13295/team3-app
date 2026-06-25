<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>閲覧履歴</title>

   
</head> <link rel="stylesheet" href="{{ asset('css/history.css') }}">

<body>

<?= view('header')->render() ?>

<div class="container">

    <h1>閲覧履歴</h1>

    @if($viewedProducts->isEmpty())
        <p>履歴はありません</p>
    @else

        <div class="product-grid">

            @foreach($viewedProducts as $item)

                <div class="product-card">

                    <a href="/products/{{ $item->id }}">

                        <!-- ✅ 画像表示 -->
                        @if($item->images->first())
                            <img src="{{ asset('storage/' . $item->images->first()->image_path) }}">
                        @else
                            <img src="{{ asset('images/no-image.png') }}">
                        @endif

                        <p class="name">{{ $item->product_name }}</p>

                        <p class="price">
                            ¥{{ number_format($item->price) }}
                        </p>

                    </a>

                </div>

            @endforeach

        </div>

    @endif

</div>
<?= view('footer')->render() ?>
</body>
</html>