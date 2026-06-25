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
>>>>>>> 0db95a8c9705c0d51aa6cc1da8960e2926b2cf31

        <!-- 左 -->
        <div class="detail-left">
            <img class="main-image"
                src="{{ asset('storage/' . $product->images->first()->image_path) }}">
        </div>

<<<<<<< HEAD
        <!-- 右 -->
        <div class="detail-right">

            <h1>{{ $product->product_name }}</h1>

            <!-- 商品の下に平均星 -->
            @if($product->reviewCount() > 0)
            <a href="#reviews" class="title-rating">
                @php $avg = $product -> averageRating(); @endphp
                <span class="title-stars">
                    @for($i = 1; $i <= 5; $i++) {{ $i <= round($avg) ? '★' : '☆' }}@endfor
                        </span>
                        <span class="title-avg">{{ $avg }}</span>
                        <span class="title-count">({{ $product->reviewCount() }}件) </span>
            </a>
            @endif

            <p class="description">
                {{ $product->description }}
            </p>

            <!-- 購入ボックス -->
            <div class="buy-box">
                <p class="price">
                    ¥{{ number_format($product->price) }}
                </p>

                <!-- ✅ 数量 -->
                <div class="quantity-box">
                    <button type="button" id="minusBtn">-</button>
                    <input type="number" id="quantity" value="1" min="1">
                    <button type="button" id="plusBtn">+</button>
                </div>

                <!-- ✅ ✅ 購入（数量送るようにする） -->
                <form action="{{ route('purchase.form') }}" method="GET">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" id="buy-quantity" value="1">
                    <button type="submit" class="buy-btn">購入する</button>
                </form>

                <!-- ✅ カート -->
                <button class="cart-btn" data-id="{{ $product->id }}">
                    カートに追加
                </button>
            </div>

            <!-- 戻る -->
            <a href="/" class="back-btn">← 一覧へ戻る</a>
        </div>
    </div>

    <!-- 横いっぱいのセクション -->
    <div class="detail-sections">

        <!-- 関連商品 -->
        @if($viewedProducts->count() > 0)
        <section class="product-row-section">
            <h2 class="row-title">関連商品</h2>
            <div class="row-scroll">
                @foreach($relatedProducts as $rp)
                <a href="{{ route('products.show', $rp->id) }}" class="row-card">
                    <div class="row-img">
                        @if($rp->mainImage && $rp->mainImage->image_path)
                            <img src="{{ asset('storage/' . $rp->mainImage->image_path) }}" alt="{{ $rp->product_name }}">
                        @else
                            <img src="{{ asset('images/no-image.png') }}" alt="">
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
                        <img src="{{ asset('storage/' . $vp->mainImage->image_path) }}" alt="{{ $vp->product_name }}">

                        @else
                        <img src="{{ asset('images/no-image.png') }}" alt="">
                        @endif
                    </div>
                    <div class="row-name">{{ $vp->product_name }}</div>
                    <div class="row-price">{{ number_format($vp->price) }}円</div>
                </a>
                @endforeach
            </div>
        </section>
        @endif

        <!-- レビューセクション -->
        <div class="review-section" id="reviews">
            <h2>カスタマーレビュー</h2>

            @if($product->reviewCount() > 0)
            <div class="review-summary">
                <span class="review-stars">
                    @php $avg = $product->averageRating(); @endphp
                    @for($i = 1; $i <= 5; $i++){{ $i <= round($avg) ? '★' : '☆' }}@endfor
                </span>
                
                <span class="review-avg">{{ $avg }}</span>
                <span class="review-count"> ({{ $product->reviewCount() }}件) </span>
            </div>
            @else
            <p class="no-review">まだレビューがありません。</p>
            @endif
            <!-- 投稿フォーム(ログイン時のみ) -->
            @auth
            @if(session('status'))
            <p class="review-posted">{{ session('status') }}</p>
            @endif
            <form action="{{ route('review.store', $product->id) }}" method="POST" class="review-form">
                @csrf
                <label>評価</label>
                <select name="star" required>
                    <option value="5">★★★★★</option>
                    <option value="4">★★★★☆</option>
                    <option value="3">★★★☆☆</option>
                    <option value="2">★★☆☆☆</option>
                    <option value="1">★☆☆☆☆</option>
                </select>
                <textarea name="comment" placeholder="商品の感想を書く(任意)" rows="3"></textarea>
                <button type="submit">レビューを投稿</button>
            </form>
            @else
            <p class="review-login"><a href="/login">ログイン</a>するとレビューを投稿できます。</p>
            @endauth

            <!-- レビュー一覧 -->
            <div class="review-list">
                @foreach($product->reviews as $review)
                <div class="review-item">
                    <div class="review-item-head">
                        <span class="review-item-stars">
                            @for($i = 1; $i <= 5; $i++){{ $i <= $review->star ? '★' : '☆' }}@endfor
                                </span>
                                <span class="review-item-name">{{ $review->user->user_name ?? '匿名' }}</span>
                    </div>
                    @if($review->comment)
                    <p class="review-item-comment">{{ $review->comment }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

=======
        <p class="price">¥{{ number_format($product->price) }}</p>

        <p class="description">{{ $product->description }}</p>

        <!-- ✅ お気に入り -->
        <button id="favBtn" data-id="{{ $product->id }}">
            {{ Auth::check() && \App\Models\Favorite::where('user_id', auth()->id())
            ->where('product_id',$product->id)->exists()
            ? '★ お気に入り済み'
            : '☆ お気に入りに追加' }}
        </button>

        <!-- 数量 -->
        <div class="quantity-box">
            <button type="button" id="minusBtn">-</button>
            <input type="number" id="quantity" value="1" min="1">
            <button type="button" id="plusBtn">+</button>
        </div>

        <!-- 購入 -->
        <form action="{{ route('purchase.form') }}" method="GET">
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" id="buy-quantity" value="1">
            <button type="submit" class="buy-btn">購入する</button>
        </form>

        <!-- カート -->
        <button class="cart-btn" data-id="{{ $product->id }}">
            カートに追加
        </button>

        <!-- 戻る -->
        <a href="/" class="back-btn">← 一覧へ戻る</a>

>>>>>>> 0db95a8c9705c0d51aa6cc1da8960e2926b2cf31
    </div>

<<<<<<< HEAD
    <script>
        document.addEventListener('DOMContentLoaded', function() {
=======
<!-- ================= 下：レビュー（横いっぱい） ================= -->
<div class="review-section">

    <h2>カスタマーレビュー</h2>

    @if($product->reviewCount() > 0)
        <div class="review-summary">
            <span class="review-stars">
                @php $avg = $product->averageRating(); @endphp
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

    <!-- 投稿 -->
    @auth
    <form action="{{ route('review.store', $product->id) }}" method="POST" class="review-form">
        @csrf

        <label>評価</label>
        <select name="star">
            <option value="5">★★★★★</option>
            <option value="4">★★★★☆</option>
            <option value="3">★★★☆☆</option>
            <option value="2">★★☆☆☆</option>
            <option value="1">★☆☆☆☆</option>
        </select>

        <textarea name="comment" placeholder="商品の感想を書く"></textarea>

        <button type="submit">レビューを投稿</button>
    </form>
    @else
        <p class="review-login">
            <a href="/login">ログイン</a>するとレビューを投稿できます
        </p>
    @endauth

    <!-- 一覧 -->
    <div class="review-list">
        @foreach($product->reviews as $review)
        <div class="review-item">

            <div class="review-item-head">
                <span class="review-item-stars">
                    @for($i = 1; $i <= 5; $i++)
                        {{ $i <= $review->star ? '★' : '☆' }}
                    @endfor
                </span>
                <span class="review-item-name">
                    {{ $review->user->user_name ?? '匿名' }}
                </span>
            </div>

            @if($review->comment)
                <p class="review-item-comment">{{ $review->comment }}</p>
            @endif

        </div>
        @endforeach
    </div>

</div>

<!-- ================= JS ================= -->
<script>
document.addEventListener('DOMContentLoaded', function(){
>>>>>>> 0db95a8c9705c0d51aa6cc1da8960e2926b2cf31

            const csrf = document.querySelector('meta[name="csrf-token"]').content;
            const quantityInput = document.getElementById('quantity');
            const buyQuantity = document.getElementById('buy-quantity');
            const cartBtn = document.querySelector('.cart-btn');
            const favBtn = document.getElementById('favBtn');
            const messageBox = document.getElementById('cart-message');
            const messageText = document.getElementById('cart-message-text');

<<<<<<< HEAD
            // ✅ 数量＋
            document.getElementById('plusBtn').onclick = () => {
                quantityInput.value = parseInt(quantityInput.value) + 1;
                buyQuantity.value = quantityInput.value;
            };

    // ✅ 数量−
    document.getElementById('minusBtn').onclick = () => {
        if (quantityInput.value > 1) {
            quantityInput.value--;
            buyQuantity.value = quantityInput.value;
        }
    };

    // ✅ 手入力対応（重要）
    quantityInput.addEventListener('input', () => {
        let val = parseInt(quantityInput.value) || 1;
        if (val < 1) val = 1;
        quantityInput.value = val;
        buyQuantity.value = val;
    });

    // ✅ カート
    cartBtn.onclick = function() {
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({
                product_id: this.dataset.id,
                quantity: quantityInput.value
            })
        })
        .then(res => {
            if (res.status === 401) {
                location.href = "/login";
                return;
            }
            return res.json();
        })
        .then(data => {
            if (!data) return;

            messageText.innerText = data.message;
            messageBox.style.display = "flex";

            setTimeout(() => {
                messageBox.style.display = "none";
            }, 3000);
        });
    };

            // ✅ お気に入り
            favBtn.onclick = function() {
                fetch('/favorite/toggle', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf
                        },
                        body: JSON.stringify({
                            product_id: this.dataset.id
                        })
                    })
                    .then(res => {
                        if (res.status === 401) {
                            location.href = "/login";
                            return;
                        }
                        return res.json();
                    })
                    .then(data => {
                        if (!data) return;
                        favBtn.innerText =
                            data.status === 'added' ?
                            '★ お気に入り済み' :
                            '☆ お気に入り';
                    });
            };
        });
    </script>
</body>

</html>
=======
    // 数量
    plusBtn.onclick = () => {
        quantityInput.value++;
        buyQuantity.value = quantityInput.value;
    };

    minusBtn.onclick = () => {
        if(quantityInput.value > 1){
            quantityInput.value--;
            buyQuantity.value = quantityInput.value;
        }
    };

    // カート
    cartBtn.onclick = function(){
        fetch('/cart/add',{
            method:'POST',
            headers:{
                'Content-Type':'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: JSON.stringify({
                product_id:this.dataset.id,
                quantity: quantityInput.value
            })
        })
        .then(res=>res.json())
        .then(data=>{
            document.getElementById('cart-message-text').innerText = data.message;
            document.getElementById('cart-message').style.display = "flex";
            setTimeout(()=>document.getElementById('cart-message').style.display="none",3000);
        });
    };

    // お気に入り
    favBtn.onclick = function(){
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
                data.status === 'added'
                ? '★ お気に入り済み'
                : '☆ お気に入りに追加';
        });
    };
});
</script>

<?= view('footer')->render() ?>

</body>
</html>
>>>>>>> 0db95a8c9705c0d51aa6cc1da8960e2926b2cf31
