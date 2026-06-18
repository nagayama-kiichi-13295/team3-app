<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>商品詳細</title>
 }}">
</head>
<body>

<h1>{{ $product->name }}</h1>

<div>
@foreach($product->images as $image)
     }}" width="200">
@endforeach
</div>

<p>{{ number_format($product->price) }}円</p>

/← 戻る</a>

</body>
</html>