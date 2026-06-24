<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>スニーカー販売サイト</title>

<link rel="stylesheet" href="{{ asset('css/home.css') }}">

<style>
    /* 検索エリア全体のレイアウト（中央寄せ＆2段組み） */
    
    /* 検索バーとボタンを横並びに*/
    .search-area {
        display: flex;
        justify-content: center; /* 横方向の真ん中に配置 */
        align-items: center;     /* 上下の高さを揃える */
        gap: 5px;                /* バーとボタンの間のすき間 */
        margin: 20px auto;       /* 左右のマージンを auto にして中央寄せを確実にする */
        width: 100%;             /* 横幅いっぱいに広げた上で中身を中央にする */
        box-sizing: border-box;
    }

    /* ついでに見た目を少し整える場合（お好みで調整してください） */
    #searchInput {
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 500px;            /* バーの幅 */
    }


    /* 検索ボタンのスタイリング */
    #searchBtn {
        padding: 8px 16px;
        background-color: #333;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    /* 2段目：価格入力エリア（幅を検索バーの250pxと完全に一致させる） */
    .price-filter-row {
        display: flex;
        justify-content: space-between; /* 両端に広げて間を「〜」にする */
        align-items: center;
        width: 250px;            /* 💡 検索バーと同じ250pxに指定 */
        box-sizing: border-box;
        font-size: 14px;
        color: #333;
        /* 右側の検索ボタンの幅（約60px）の分だけ左に寄るのを防ぐため、ボタンの幅+gapの分の右余白を作る */
        margin-right: 65px; 
    }

    /* 価格の入力欄1つあたりのスタイル */
    .price-input-container {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .price-input {
        padding: 8px 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 85px;             /* 2つ並べて250pxに収まる幅に調整 */
        text-align: right;       /* 数字を右寄せ */
        box-sizing: border-box;
    }

    /* カテゴリボタンのスタイリング */
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
        transition: 0.2s;
    }
    .category-btn.active {
        background-color: #333;
        color: #fff;
        border-color: #333;
    }

    

</style>
</head>
<body>

<?= view('header')->render() ?>

<div class="search-area">
    <div class="search-row">
        <input type="text" id="searchInput" placeholder="商品名を検索"><button id="searchBtn">検索</button>
    </div>
    
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
            <h3 style="color: black !important; margin: 5px 0;">{{ $product->product_name }}</h3>
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
    const searchBtn = document.getElementById('searchBtn');
    const minPriceInput = document.getElementById('minPriceInput');
    const maxPriceInput = document.getElementById('maxPriceInput');

    function filterProducts() {
        const activeBtn = document.querySelector('.category-btn.active');
        const targetCategory = activeBtn ? activeBtn.getAttribute('data-target') : 'all';
        
        const searchText = searchInput.value.toLowerCase().replace(/[  ]+/g, ' ').trim();
        
        const minPrice = minPriceInput.value ? parseInt(minPriceInput.value, 10) : null;
        const maxPrice = maxPriceInput.value ? parseInt(maxPriceInput.value, 10) : null;

        products.forEach(product => {
            const productCategory = String(product.getAttribute('data-category') || '').trim();
            const targetCategoryStr = String(targetCategory).trim();
            const productPrice = parseInt(product.getAttribute('data-price') || '0', 10);

            const h3Element = product.querySelector('h3');
            if (!h3Element) return;

            const productName = h3Element.textContent.toLowerCase().replace(/\s+/g, ' ').trim();

            const matchCategory = (targetCategoryStr === 'all' || productCategory === targetCategoryStr);
            const matchSearch = (searchText === '' || productName.includes(searchText));
            const matchMinPrice = (minPrice === null || productPrice >= minPrice);
            const matchMaxPrice = (maxPrice === null || productPrice <= maxPrice);

            if (matchCategory && matchSearch && matchMinPrice && matchMaxPrice) {
                product.style.display = 'inline-block';
            } else {
                product.style.display = 'none';
            }
        });
    }

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            buttons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            filterProducts();
        });
    });

    searchInput.addEventListener('input', filterProducts);
    minPriceInput.addEventListener('input', filterProducts);
    maxPriceInput.addEventListener('input', filterProducts);

    if (searchBtn) {
        searchBtn.addEventListener('click', filterProducts);
    }
});
</script>

</body>
</html>