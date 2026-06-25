<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>{{ $product->product_name }}</title>

<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

<?= view('header')->render() ?>

<!-- 通知 -->
<div id="cart-message" class="cart-message" style="display:none;">
    <span id="cart-message-text"></span>
    <a href="/cart" class="view-cart-btn">カートを見る</a>
</div>

<!-- ================= 上：商品 ================= -->
<div class="detail-container">

    <!-- 左：画像 -->
    <div class="detail-left">
        <img class="main-image"
             src="{{ asset('storage/' . $product->images->first()->image_path) }}">
    </div>

    <!-- 右：情報 -->
    <div class="detail-right">

        <h1>{{ $product->product_name }}</h1>

        <!-- ⭐ タイトル下レビュー -->
        @if($product->reviewCount() > 0)
        <a href="#reviews" class="title-rating">
            @php $avg = $product->averageRating(); @endphp
            <span class="title-stars">
                @for($i = 1; $i <= 5; $i++)
                    {{ $i <= round($avg) ? '★' : '☆' }}
                @endfor
            </span>
            <span class="title-avg">{{ $avg }}</span>
            <span class="title-count">({{ $product->reviewCount() }}件)</span>
        </a>
        @endif

        <p class="description">{{ $product->description }}</p>

        <!-- ⭐ お気に入り -->
        <button id="favBtn" data-id="{{ $product->id }}">
            {{ Auth::check() && \App\Models\Favorite::where('user_id', auth()->id())
            ->where('product_id',$product->id)->exists()
            ? '★ お気に入り済み'
            : '☆ お気に入りに追加' }}
        </button>

        <!-- 購入BOX -->
        <div class="buy-box">

            <p class="price">¥{{ number_format($product->price) }}</p>

            <div class="quantity-box">
                <button type="button" id="minusBtn">-</button>
                <input type="number" id="quantity" value="1" min="1">
                <button type="button" id="plusBtn">+</button>
            </div>

            <form action="{{ route('purchase.form') }}" method="GET">
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" id="buy-quantity" value="1">
                <button type="submit" class="buy-btn">購入する</button>
            </form>

            <button class="cart-btn" data-id="{{ $product->id }}">
                カートに追加
            </button>

        </div>

        <a href="/" class="back-btn">← 一覧へ戻る</a>

    </div>
</div>

<!-- ================= 横エリア ================= -->
<div class="detail-sections">

    <!-- 関連商品 -->
    @if(isset($relatedProducts))
    <section class="product-row-section">

        <h2 class="row-title">関連商品</h2>
        <div class="row-scroll">
            @foreach($relatedProducts as $rp)
            <a href="{{ route('products.show', $rp->id) }}" class="row-card">
                <div class="row-img">
                    @if($rp->mainImage && $rp->mainImage->image_path)
                        <img src="{{ asset('storage/'.$rp->mainImage->image_path) }}">
                    @else
                        <img src="{{ asset('images/no-image.png') }}">
                    @endif
                </div>
                <div class="row-name">{{ $rp->product_name }}</div>
                <div class="row-price">{{ number_format($rp->price) }}円</div>
            </a>
            @endforeach
        </div>

        <h2 class="row-title">最近見た商品</h2>
        <div class="row-scroll">
            @foreach($viewedProducts as $vp)
            <a href="{{ route('products.show', $vp->id) }}" class="row-card">
                <div class="row-img">
                    @if($vp->mainImage && $vp->mainImage->image_path)
                        <img src="{{ asset('storage/'.$vp->mainImage->image_path) }}">
                    @else
                        <img src="{{ asset('images/no-image.png') }}">
                    @endif
                </div>
                <div class="row-name">{{ $vp->product_name }}</div>
                <div class="row-price">{{ number_format($vp->price) }}円</div>
            </a>
            @endforeach
        </div>

    </section>
    @endif

    <!-- ================= レビュー ================= -->
    <div class="review-section" id="reviews">

        <h2>カスタマーレビュー</h2>

        @if($product->reviewCount() > 0)
        <div class="review-summary">
            @php $avg = $product->averageRating(); @endphp
            <span class="review-stars">
                @for($i = 1; $i <= 5; $i++)
                    {{ $i <= round($avg) ? '★' : '☆' }}
                @endfor
            </span>
            <span class="review-avg">{{ $avg }}</span>
            <span class="review-count">({{ $product->reviewCount() }}件)</span>
        </div>
        @else
        <p class="no-review">まだレビューがありません。</p>
        @endif

        @auth
        <form action="{{ route('review.store', $product->id) }}" method="POST" class="review-form">
            @csrf
            <select name="star">
                <option value="5">★★★★★</option>
                <option value="4">★★★★☆</option>
                <option value="3">★★★☆☆</option>
                <option value="2">★★☆☆☆</option>
                <option value="1">★☆☆☆☆</option>
            </select>
            <textarea name="comment"></textarea>
            <button type="submit">レビュー投稿</button>
        </form>
        @endauth

        <div class="review-list">
            @foreach($product->reviews as $review)
            <div class="review-item">
                <span>
                    @for($i = 1; $i <= 5; $i++)
                        {{ $i <= $review->star ? '★' : '☆' }}
                    @endfor
                </span>
                <span>{{ $review->user->user_name ?? '匿名' }}</span>
                @if($review->comment)
                <p>{{ $review->comment }}</p>
                @endif
            </div>
            @endforeach
        </div>

    </div>

</div>

<!-- ================= JS ================= -->
<script>
document.addEventListener('DOMContentLoaded', function(){

    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    const q = document.getElementById('quantity');
    const buyQ = document.getElementById('buy-quantity');

    const plusBtn = document.getElementById('plusBtn');   // ✅追加
    const minusBtn = document.getElementById('minusBtn'); // ✅追加

    const msg = document.getElementById('cart-message');  // ✅修正
    const text = document.getElementById('cart-message-text'); // ✅修正

    const cartBtn = document.querySelector('.cart-btn');

    // ✅ 数量＋
    plusBtn.onclick = () => {
        q.value = parseInt(q.value) + 1;
        buyQ.value = q.value;
    };

    // ✅ 数量−
    minusBtn.onclick = () => {
        if(parseInt(q.value) > 1){
            q.value = parseInt(q.value) - 1;
            buyQ.value = q.value;
        }
    };

    // ✅ 手入力対応（そのまま残す）
    q.addEventListener('input', () => {
        let val = parseInt(q.value) || 1;
        if (val < 1) val = 1;
        q.value = val;
        buyQ.value = val;
    });

    // ✅ カート
    cartBtn.onclick = function(){
    fetch('/cart/add',{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN': csrf
        },
        body: JSON.stringify({
            product_id:this.dataset.id,
            quantity:q.value
        })
    })
    .then(res=>{
        if(res.status === 401){
            location.href="/login";
            return;
        }
        return res.json();
    })
    .then(data=>{
        if(!data) return;

        text.innerText = data.message;
        msg.style.display = "flex";

        setTimeout(()=>{
            location.href = "/cart";
        }, 1000);

        // ✅ これがないと遷移しない
        location.href = "/cart";
    });
};

    // ✅ お気に入り（そのまま）
    const fav = document.getElementById('favBtn');
    fav.onclick=function(){
        fetch('/favorite/toggle',{
            method:'POST',
            headers:{
                'Content-Type':'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({ product_id:this.dataset.id })
        })
        .then(res=>res.json())
        .then(data=>{
            this.innerText =
                data.status==='added'
                ? '★ お気に入り済み'
                : '☆ お気に入りに追加';
        });
    };

});
</script>

</body>
</html>