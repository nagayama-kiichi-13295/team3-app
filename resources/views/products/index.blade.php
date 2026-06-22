<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>スニーカー販売サイト</title>

<link rel="stylesheet" href="{{ asset('css/home.css') }}">

<style>
    /* 💡 ボタンの簡単なスタイリング */
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

<?= view('header') -> render() ?>

<div class="search-area">
    <input type="text" id="searchInput" placeholder="商品名を検索"><button id="searchBtn">検索</button>
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
   style="text-decoration:none;color:black;">

    <div class="card">

        <div class="image">
            @if($product->mainImage && $product->mainImage->image_path)
                <img src="{{ asset('storage/' . $product->mainImage->image_path) }}"
                     style="width:100%; height:100%; object-fit:cover;">
            @else
                <img src="{{ asset('images/no-image.png') }}"
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.category-btn');
    const products = document.querySelectorAll('.product-item');
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');

    function filterProducts() {
        const activeBtn = document.querySelector('.category-btn.active');
        const targetCategory = activeBtn ? activeBtn.getAttribute('data-target') : 'all';
        
        // 【強化】全角スペースも半角スペースに変換して、前後の空白を除去
        const searchText = searchInput.value.toLowerCase().replace(/ /g, ' ').trim();

        console.log('--- 検索開始 ---');
        console.log('入力された文字: "' + searchText + '"');
        console.log('選択中のカテゴリ: ' + targetCategory);

        products.forEach(product => {
            const productCategory = String(product.getAttribute('data-category')).trim();
            const targetCategoryStr = String(targetCategory).trim();

            // 【強化】商品名に含まれる改行やタブ、連続するスペースを全て「半角スペース1つ」に綺麗に整える
            const productName = product.querySelector('h3').textContent.toLowerCase().replace(/\s+/g, ' ').trim();

            const matchCategory = (targetCategoryStr === 'all' || productCategory === targetCategoryStr);
            const matchSearch = productName.includes(searchText);

            // 🛠️ ブラウザのコンソールに1件ずつの判定理由を出力
            console.log(`[検証] 商品名: "${productName}" | カテゴリID: ${productCategory} -> カテゴリ一致: ${matchCategory} | 文字一致: ${matchSearch}`);

            if (matchCategory && matchSearch) {
                product.style.display = '';  
            } else {
                product.style.display = 'none';
            }
        });
    }

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            buttons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            filterProducts();
        });
    });

    searchInput.addEventListener('input', () => {
        filterProducts();
    });

    if (searchBtn) {
        searchBtn.addEventListener('click', () => {
            filterProducts();
        });
    }
});
</script>

</body>
</html>