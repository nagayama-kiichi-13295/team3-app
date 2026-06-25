<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>スニーカー販売サイト</title>
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="icon" type="image/png" href="/images/logo.png">

<style>
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
/* ✅ 上に出てる余計なナビ削除（これが重要） */
.pagination nav > div:first-child {
    display: none;
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
<!-- 自動スライドAmazon風バナー -->
 <div class="hero-banner">
    <div class="hero-track" id="heroTrack">

        <!-- ▼▼▼ スライド１: ここに画像か動画を入れる ▼▼▼ -->
         <div class="hero-slide">
            <img src="{{ asset('images/sample.jpg') }}" alt="新作">
         </div>

        <!-- ▼▼▼ スライド２: ここに画像か動画を入れる ▼▼▼ -->
         <div class="hero-slide">
            <!-- 動画を入れる場合 -->
            <video src="{{ asset('videos/perfect.mp4') }}" autoplay muted loop playsinline></video>
         </div>

        <!-- ▼▼▼ スライド３: ここに画像か動画を入れる ▼▼▼ -->
         <div class="hero-slide">
            <img src="{{ asset('images/logo.png') }}" alt="新作">
         </div>

        <!-- ▼▼▼ スライド４: ここに画像か動画を入れる ▼▼▼ -->
         <div class="hero-slide">
            <img src="{{ asset('images/sample.jpg') }}" alt="新作">
         </div>

        <!-- ▼▼▼ スライド５: ここに画像か動画を入れる ▼▼▼ -->
         <div class="hero-slide">
            <img src="{{ asset('images/kutu.webp') }}" alt="新作">
         </div>

        <!-- ▼▼▼ スライド６: ここに画像か動画を入れる ▼▼▼ -->
         <div class="hero-slide">
            <img src="{{ asset('images/kutu2.webp') }}" alt="新作">
         </div>
    </div>
</div>

<!-- ✅ カテゴリ -->
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

<!-- 最近みた商品 -->
 @if(isset($viewedProducts) && $viewedProducts->count() > 0)
 <div class="recently-viewed">
    <h2 class="recently-title">最近見た商品</h2>
    <div class="recently-scroll">
        @foreach($viewedProducts as $vp)
        <a href="{{ route('products.show', $vp->id) }}" class="recently-card">
            <div class="recently-img">
                @if($vp->mainImage && $vp->mainImage->image_path)
                    <img src="{{ asset('storage/' . $vp->mainImage->image_path) }}" alt="{{ $vp->product_name }}">
                @else
                    <img src="{{ asset('images/no-image.png') }}" alt="">
                @endif
            </div>
            <div class="recently-name">{{ $vp->product_name }}</div>
            <div class="recently-price">{{ number_format($vp->price) }}円</div>
        </a>
        @endforeach
    </div>
 </div>
@endif

<h2 class="section-title">おすすめ商品</h2>

<div class="product-list">
@foreach($products as $product)
<div style="position: relative; display: inline-block; margin: 10px; z-index: 1;">

    <button type="button" class="ajax-fav-btn" data-id="{{ $product->id }}">
        {{ Auth::check() && \App\Models\Favorite::where('user_id', auth()->id())->where('product_id', $product->id)->exists() ? '★' : '☆' }}
    </button>

    <a href="{{ route('products.show', $product->id) }}"
       class="product-item"
       data-category="{{ $product->category_id }}"
       data-price="{{ $product->price }}"
       style="margin: 0; display: block; z-index: 0;">

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
            
            <div class="card-rating">
                @if($product->reviews_count > 0)
                    ★ {{ round($product->reviews_avg_star, 1) }} ({{ $product->reviews_count }})
                @else
                    <span class="no-rating">レビューなし</span>
                @endif
            </div>
            </div>
        </div>
    </a>

</div>
@endforeach
</div>

<!-- pagination -->
 <div class="pagination">
        {{ $products->links() }}
 </div>



<script>
    let heroIndex = 0;
    const heroTrack = document.getElementById('heroTrack');
    const heroCount = heroTrack.children.length;
    const heroDots = document.getElementById('heroDots');

    // ドットをスライド枚数分自動生成
    for (let i = 0; i < heroCount; i++) {
        const dot = document.createElement('button');
        if (i === 0) dot.classList.add('active');
        dot.addEventListener('click', () => {heroIndex = i; renderHero(); });
        heroDots.appendChild(dot);
    }

    function renderHero() {
        heroTrack.style.transform = 'translateX(' + (-heroIndex * 100) + '%)';
        const dots = heroDots.children;
        for (let i = 0; i < dots.length; i++) {
            dots[i].classList.toggle('active', i === heroIndex);
        }
    }

    function moveHero(dir) {
        heroIndex = (heroIndex + dir + heroCount) % heroCount;
        renderHero();
    }

    setInterval(() => moveHero(1), 5000); // 5秒ごとに自動で次へ
document.addEventListener('DOMContentLoaded', function() {

    const products = document.querySelectorAll('.product-list > div');
    const searchInput = document.getElementById('searchInput');
    const minPriceInput = document.getElementById('minPriceInput');
    const maxPriceInput = document.getElementById('maxPriceInput');
    const categoryChecks = document.querySelectorAll('.category-check');

    // 1. 検索・絞り込みの関数（安全ガード付き）
    function filterProducts() {
        const searchText = searchInput.value.toLowerCase().trim();
        const minPrice = minPriceInput.value ? parseInt(minPriceInput.value) : null;
        const maxPrice = maxPriceInput.value ? parseInt(maxPriceInput.value) : null;

        const selectedCategories = Array.from(categoryChecks)
            .filter(c => c.checked)
            .map(c => c.value);

        products.forEach(product => {
            const productItem = product.querySelector('.product-item');
            if (!productItem) return; // aタグがない場合はスキップ

            const productCategory = productItem.getAttribute('data-category');
            const productPrice = parseInt(productItem.getAttribute('data-price'));
            
            const h3Element = product.querySelector('h3');
            const name = h3Element ? h3Element.textContent.toLowerCase() : '';

            const matchCategory = selectedCategories.length === 0 || selectedCategories.includes(productCategory);
            const matchSearch = (searchText === '' || name.includes(searchText));
            const matchMin = (minPrice === null || productPrice >= minPrice);
            const matchMax = (maxPrice === null || productPrice <= maxPrice);

            product.style.display = (matchCategory && matchSearch && matchMin && matchMax) ? 'inline-block' : 'none';
        });
    }

    // イベントリスナーの登録
    if (searchInput) searchInput.addEventListener('input', filterProducts);
    if (minPriceInput) minPriceInput.addEventListener('input', filterProducts);
    if (maxPriceInput) maxPriceInput.addEventListener('input', filterProducts);
    categoryChecks.forEach(check => check.addEventListener('change', filterProducts));

    // 2. お気に入り非同期通信（カッコの閉じを厳密に修正）
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
                if (!res.ok) {
                    if (res.status === 401) {
                        location.href = "/login";
                        return;
                    }
                    throw new Error(`サーバーエラー: ステータスコード ${res.status}`);
                }
                return res.json();
            })
            .then(data => {
                if (data && data.status) {
                    this.innerText = data.status === 'added' ? '★' : '☆';
                }
            })
            .catch(err => {
                console.error("【通信エラー】:", err.message);
            });
        }); // 👈 btn.addEventListener の閉じ
    }); // 👈 forEach の閉じ

}); // 👈 DOMContentLoaded の閉じ
</script>
<?= view('footer')->render() ?>
</body>
</html>