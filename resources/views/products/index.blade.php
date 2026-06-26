<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>スニーカー販売サイト</title>

<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="icon" type="image/png" href="/images/logo.png">

</head>

<body>

<?= view('header')->render() ?>

<!-- ===== スライダー ===== -->
<div class="hero-banner">
    <div class="hero-track" id="heroTrack">

        <!-- ▼▼▼ スライド１: ここに画像か動画を入れる ▼▼▼ -->
        <div class="hero-slide">
            <img src="{{ asset('images/sample.jpg') }}">
        </div>
        <!-- ▼▼▼ スライド２: ここに画像か動画を入れる ▼▼▼ -->
        <div class="hero-slide">
            <img src="{{ asset('images/kutu3.jpg') }}" alt="新作">
        </div>

        <!-- ▼▼▼ スライド３: ここに画像か動画を入れる ▼▼▼ -->
         <div class="hero-slide">
            <img src="{{ asset('images/logo.png') }}" alt="新作">
         </div>

        <!-- ▼▼▼ スライド４: ここに画像か動画を入れる ▼▼▼ -->
         <div class="hero-slide">
            <img src="{{ asset('images/kutu4.jpg') }}" alt="新作">
         </div>

        <!-- ▼▼▼ スライド５: ここに画像か動画を入れる ▼▼▼ -->
         <div class="hero-slide">
            <img src="{{ asset('images/kutu.webp') }}" alt="新作">
         </div>



        <!-- ▼▼▼ スライド７: ここに画像か動画を入れる ▼▼▼ -->
         <div class="hero-slide">
            <img src="{{ asset('images/kutu5.jpg') }}" alt="新作">
         </div>
    </div>

    <div class="hero-fade"></div>

    <button class="hero-arrow prev" onclick="moveHero(-1)">‹</button>
    <button class="hero-arrow next" onclick="moveHero(1)">›</button>
</div>

<!-- ===== バナー ===== -->
<div class="banner">
    <h1>人気スニーカー特集</h1>
    <p>限定モデル続々入荷中！</p>
</div>

<!-- ===== 最近見た商品 ===== -->
@if(isset($viewedProducts) && $viewedProducts->count() > 0)

<h2 class="section-title">最近見た商品</h2>

<div class="recently-viewed">

    <div class="recently-scroll">
        @foreach($viewedProducts as $vp)
        <div class="recently-card">

            <div class="recently-img">

                <button class="ajax-fav-btn" data-id="{{ $vp->id }}">
                    {{ Auth::check() && \App\Models\Favorite::where('user_id', auth()->id())->where('product_id',$vp->id)->exists() ? '★':'☆' }}
                </button>

                <a href="{{ route('products.show',$vp->id) }}">
                    @if($vp->mainImage && $vp->mainImage->image_path)
                        <img src="{{ asset('storage/'.$vp->mainImage->image_path) }}">
                    @else
                        <img src="{{ asset('images/no-image.png') }}">
                    @endif
                </a>

            </div>

            <div class="recently-name">{{ $vp->product_name }}</div>
            <div class="recently-price">{{ number_format($vp->price) }}円</div>

        </div>
        @endforeach
    </div>

</div>
@endif
<!-- ===== 商品一覧 ===== -->
<h2 class="section-title">おすすめ商品</h2>

<div class="product-list">

@foreach($products as $product)
<div class="product-card">

    <div class="card">

        <div class="image">

            <!-- ✅ お気に入り -->
            <button class="ajax-fav-btn" data-id="{{ $product->id }}">
                {{ Auth::check() && \App\Models\Favorite::where('user_id', auth()->id())->where('product_id',$product->id)->exists() ? '★':'☆' }}
            </button>

            <!-- ✅ 画像だけリンク -->
            <a href="{{ route('products.show',$product->id) }}">
                @if($product->mainImage && $product->mainImage->image_path)
                    <img src="{{ asset('storage/'.$product->mainImage->image_path) }}">
                @else
                    <img src="{{ asset('images/no-image.png') }}">
                @endif
            </a>

        </div>

        <div class="card-body">
    <a href="{{ route('products.show',$product->id) }}">
        <h3>{{ $product->product_name }}</h3>
    </a>

    <div class="price">
        {{ number_format($product->price) }}円
    </div>

    <!-- ✅ ★レビュー復活 -->
    <div class="card-rating">
        @if($product->reviews_count > 0)
            ★ {{ round($product->reviews_avg_star, 1) }} 
            ({{ $product->reviews_count }})
        @else
            <span class="no-rating">レビューなし</span>
        @endif
    </div>
</div>


    </div>

</div>
@endforeach

</div>

<!-- ===== pagination ===== -->
<div class="pagination">
    {{ $products->links() }}
</div>

<!-- ===== JS ===== -->
<script>

// スライダー
let heroIndex = 0;
const heroTrack = document.getElementById('heroTrack');
const heroCount = heroTrack.children.length;

function moveHero(dir) {
    heroIndex = (heroIndex + dir + heroCount) % heroCount;
    heroTrack.style.transform = 'translateX(' + (-heroIndex * 100) + '%)';
}

setInterval(() => moveHero(1), 5000);


// ✅ お気に入り（クリック可能にしてる）
document.querySelectorAll('.ajax-fav-btn').forEach(btn=>{
    btn.addEventListener('click', function(e){
        e.preventDefault();
        e.stopPropagation(); // ←これが重要

        fetch('/favorite/toggle',{
            method:'POST',
            headers:{
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },
            body:JSON.stringify({product_id:this.dataset.id})
        })
        .then(res=>res.json())
        .then(data=>{
            this.innerText = data.status === 'added' ? '★' : '☆';
        });
    });
});

</script>

<?= view('footer')->render() ?>

</body>
</html>