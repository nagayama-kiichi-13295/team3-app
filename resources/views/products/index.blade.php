<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>スニーカー販売サイト</title>

<link rel="stylesheet" href="{{ asset('css/home.css') }}">

<style>

/* ===== 検索エリア ===== */
.search-area {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
    margin: 20px auto;
}

/* ✅ 検索ボックス（小さく＆丸） */
#searchInput {
    width: 500px;   /* ← ここを大きくするんだ */
    padding: 8px 14px;
    border: 1px solid #ddd;
    border-radius: 25px;
    font-size: 14px;
}


#searchInput:focus {
    border-color: #333;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
}

/* ===== 価格 ===== */
.price-filter-row {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
}

.price-input {
    width: 80px;
    padding: 6px 8px;
    border: 1px solid #ddd;
    border-radius: 6px;
}

/* ===== カテゴリ（タグボタン） ===== */
.category-filter {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 12px;
    margin: 25px 0;
}

/* チェックボックス非表示 */
.category-tag input {
    display: none;
}

/* ボタン見た目 */
.category-tag span {
    display: inline-block;
    padding: 8px 18px;
    border-radius: 999px;
    border: 1px solid #ddd;
    background: #fff;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.25s ease;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

/* ホバー */
.category-tag span:hover {
    background: #f5f5f5;
    transform: translateY(-2px);
}

/* ✅ 選択状態 */
.category-tag input:checked + span {
    background: #111;
    color: #fff;
    border-color: #111;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

.card-body h3 {
    font-size: 14px;
    line-height: 1.4;
    height: 40px; /* ← 高さを固定 */
    
    display: -webkit-box;
    -webkit-line-clamp: 2; /* ← 最大2行 */
    -webkit-box-orient: vertical;
    overflow: hidden;
}

</style>
</head>

<body>

<?= view('header')->render() ?>

<div class="banner">
    <h1>人気スニーカー特集</h1>
    <p>限定モデル続々入荷中！</p>
</div>

<div class="product-list">
@foreach($products as $product)
<a href="{{ route('products.show', $product->id) }}"
   class="product-item"
   data-category="{{ $product->category_id }}"
   data-price="{{ $product->price }}"
   style="text-decoration:none; color:black; display:inline-block;">

    <div class="card">
        <div class="image">
            @if($product->mainImage && $product->mainImage->image_path)
                <img src="{{ asset('storage/' . $product->mainImage->image_path) }}" style="width:100%; height:100%; object-fit:cover;">
            @else
                <img src="{{ asset('images/no-image.png') }}" style="width:100%; height:100%; object-fit:cover;">
            @endif
        </div>

        <div class="card-body">
            <h3>{{ $product->product_name }}</h3>
            <div class="price">
                {{ number_format($product->price) }}円
            </div>
        </div>
    </div>

</a>
@endforeach
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const products = document.querySelectorAll('.product-item');
    const minPriceInput = document.getElementById('minPriceInput');
    const maxPriceInput = document.getElementById('maxPriceInput');

    function filterProducts() {
        const minPrice = minPriceInput.value ? parseInt(minPriceInput.value) : null;
        const maxPrice = maxPriceInput.value ? parseInt(maxPriceInput.value) : null;

        products.forEach(product => {
            const productPrice = parseInt(product.getAttribute('data-price'));

            const matchMin = (minPrice === null || productPrice >= minPrice);
            const matchMax = (maxPrice === null || productPrice <= maxPrice);

            product.style.display = (matchMin && matchMax) ? 'inline-block' : 'none';
        });
    }

    minPriceInput.addEventListener('input', filterProducts);
    maxPriceInput.addEventListener('input', filterProducts);

});
</script>

</body>
</html>