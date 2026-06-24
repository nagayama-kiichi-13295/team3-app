<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>スニーカー販売サイト</title>

<link rel="stylesheet" href="{{ asset('css/home.css') }}">

<style>
/* 検索エリア */
.search-area {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 40px; /* ✅ 間隔広げた */
    margin: 20px auto;
    width: 100%;
}

/* 検索入力 */
#searchInput {
    padding: 8px 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 400px;
}

/* 価格エリア */
.price-filter-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 250px;
    box-sizing: border-box;
    font-size: 14px;
    color: #333;
    margin-right: 65px;
}

.price-input-container {
    display: flex;
    align-items: center;
    gap: 4px;
}

.price-input {
    padding: 8px 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 85px;
    text-align: right;
}

/* カテゴリ */
.category-filter {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin: 20px 0;
}

.category-btn {
    padding: 8px 16px;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    border-radius: 20px;
    cursor: pointer;
}

.category-btn.active {
    background-color: #333;
    color: #fff;
}
</style>
</head>

<body>

<?= view('header')->render() ?>

<!-- ✅ 検索エリア -->
<div class="search-area">

    <!-- ✅ ボタン削除 -->
    <input type="text" id="searchInput" placeholder="商品名を検索">

    <div class="price-filter-row">
        <div class="price-input-container">
            <input type="number" id="minPriceInput" class="price-input" placeholder="下限なし" min="0"> 円
        </div>
        <span>〜</span>
        <div class="price-input-container">
            <input type="number" id="maxPriceInput" class="price-input" placeholder="上限なし" min="0"> 円
        </div>
    </div>

</div>

<div class="category-filter">
    <button class="category-btn active" data-target="all">すべて</button>
    <button class="category-btn" data-target="1">靴</button>
</div>

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
            <h3 style="color: black; margin: 5px 0;">{{ $product->product_name }}</h3>
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

    const buttons = document.querySelectorAll('.category-btn');
    const products = document.querySelectorAll('.product-item');
    const searchInput = document.getElementById('searchInput');
    const minPriceInput = document.getElementById('minPriceInput');
    const maxPriceInput = document.getElementById('maxPriceInput');

    function filterProducts() {

        const activeBtn = document.querySelector('.category-btn.active');
        const targetCategory = activeBtn ? activeBtn.getAttribute('data-target') : 'all';

        const searchText = searchInput.value.toLowerCase().trim();
        const minPrice = minPriceInput.value ? parseInt(minPriceInput.value) : null;
        const maxPrice = maxPriceInput.value ? parseInt(maxPriceInput.value) : null;

        products.forEach(product => {

            const productCategory = product.getAttribute('data-category');
            const productPrice = parseInt(product.getAttribute('data-price'));

            const name = product.querySelector('h3').textContent.toLowerCase();

            const matchCategory = (targetCategory === 'all' || productCategory === targetCategory);
            const matchSearch = (searchText === '' || name.includes(searchText));
            const matchMin = (minPrice === null || productPrice >= minPrice);
            const matchMax = (maxPrice === null || productPrice <= maxPrice);

            product.style.display = (matchCategory && matchSearch && matchMin && matchMax)
                ? 'inline-block'
                : 'none';
        });
    }

    buttons.forEach(btn => {
        btn.addEventListener('click', function() {
            buttons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            filterProducts();
        });
    });

    searchInput.addEventListener('input', filterProducts);
    minPriceInput.addEventListener('input', filterProducts);
    maxPriceInput.addEventListener('input', filterProducts);

});
</script>

</body>
</html>