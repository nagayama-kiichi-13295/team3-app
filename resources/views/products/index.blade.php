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
</style>
</head>

<body>

<?= view('header')->render() ?>

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
    <div class="hero-fade"></div>

    <button class="hero-arrow prev" onclick="moveHero(-1)" aria-label="前へ"><</button>
    <button class="hero-arrow next" onclick="moveHero(1)" aria-label="次へ">></button>
    
    <div class="hero-dots" id="heroDots"></div>
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
</script>
<?= view('footer')->render() ?>
</body>
</html>