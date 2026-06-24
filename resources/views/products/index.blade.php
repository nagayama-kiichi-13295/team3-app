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

/* 💡 既存の .card-body h3 などの下あたりに貼り付けてください */
.product-item {
    position: relative; /* 💡 これが抜けていると、z-indexが効きません */
    display: inline-block;
    text-decoration: none;
    color: black;
}

.ajax-fav-btn {
    position: absolute !important; /* 💡 最優先で絶対配置にする */
    top: 15px;
    right: 15px;
    z-index: 999 !important; /* 💡 カード（aタグ）よりも圧倒的に手前に出す */
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid #ddd;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    cursor: pointer;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    transition: all 0.2s ease;
}

.ajax-fav-btn:hover {
    background: #fff;
    transform: scale(1.05);
}
</style>
</head>

<body>

<?= view('header')->render() ?>

<div class="search-area">
    <input type="text" id="searchInput" placeholder="商品名を検索">

    <div class="price-filter-row">
        <input type="number" id="minPriceInput" class="price-input" placeholder="下限">
        〜
        <input type="number" id="maxPriceInput" class="price-input" placeholder="上限">
    </div>
</div>

<div class="category-filter">

    <label class="category-tag">
        <input type="checkbox" class="category-check" value="1">
        <span>靴</span>
    </label>

    <label class="category-tag">
        <input type="checkbox" class="category-check" value="2">
        <span>サンダル</span>
    </label>

    <label class="category-tag">
        <input type="checkbox" class="category-check" value="3">
        <span>ブーツ</span>
    </label>

</div>

<div class="banner">
    <h1>人気スニーカー特集</h1>
    <p>限定モデル続々入荷中！</p>
</div>

<div class="product-list">
@foreach($products as $product)
<div style="position: relative; display: inline-block; margin: 10px;">

    <button type="button" class="ajax-fav-btn" data-id="{{ $product->id }}">
        {{ Auth::check() && \App\Models\Favorite::where('user_id', auth()->id())->where('product_id', $product->id)->exists() ? '★' : '☆' }}
    </button>

    <a href="{{ route('products.show', $product->id) }}"
       class="product-item"
       data-category="{{ $product->category_id }}"
       data-price="{{ $product->price }}"
       style="margin: 0; display: block;">

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

</div>
@endforeach
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // 💡 調整：製品アイテム自体ではなく、外側の親divを非表示にするため、クラスではなく親要素を基準にします
    const products = document.querySelectorAll('.product-list > div');
    const searchInput = document.getElementById('searchInput');
    const minPriceInput = document.getElementById('minPriceInput');
    const maxPriceInput = document.getElementById('maxPriceInput');
    const categoryChecks = document.querySelectorAll('.category-check');

    function filterProducts() {
        const searchText = searchInput.value.toLowerCase().trim();
        const minPrice = minPriceInput.value ? parseInt(minPriceInput.value) : null;
        const maxPrice = maxPriceInput.value ? parseInt(maxPriceInput.value) : null;

        const selectedCategories = Array.from(categoryChecks)
            .filter(c => c.checked)
            .map(c => c.value);

        products.forEach(product => {
            const productItem = product.querySelector('.product-item');
            const productCategory = productItem.getAttribute('data-category');
            const productPrice = parseInt(productItem.getAttribute('data-price'));
            const name = product.querySelector('h3').textContent.toLowerCase();

            const matchCategory = selectedCategories.length === 0 || selectedCategories.includes(productCategory);
            const matchSearch = (searchText === '' || name.includes(searchText));
            const matchMin = (minPrice === null || productPrice >= minPrice);
            const matchMax = (maxPrice === null || productPrice <= maxPrice);

            // 💡 親のdivごと非表示にすることで、お気に入りボタンも一緒に消えます
            product.style.display = (matchCategory && matchSearch && matchMin && matchMax) ? 'inline-block' : 'none';
        });
    }

    searchInput.addEventListener('input', filterProducts);
    minPriceInput.addEventListener('input', filterProducts);
    maxPriceInput.addEventListener('input', filterProducts);
    categoryChecks.forEach(check => check.addEventListener('change', filterProducts));

    // ✅ お気に入り非同期通信
    document.querySelectorAll('.ajax-fav-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault(); 
            e.stopPropagation(); 
            const productId = this.dataset.id;
            
            fetch('/favorite/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(res => {
                if (res.status === 401) {
                    location.href = "/login";
                    return;
                }
                return res.json();
            })
            .then(data => {
                if (data) {
                    // ★ と ☆ をその場でパチッと切り替える
                    this.innerText = data.status === 'added' ? '★' : '☆';
                }
            })
            .catch(err => console.error("エラーが発生しました:", err));
        });
    });
});

</script>
<?= view('footer')->render() ?>
</body>
</html>