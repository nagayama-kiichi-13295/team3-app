<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お気に入り商品 | Sneaker Market</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        body { margin: 0; padding: 0; font-family: "Helvetica Neue", Arial, sans-serif; background-color: #f9f9f9; color: #333; }
        .fav-container { max-width: 1200px; margin: 40px auto; padding: 0 20px; min-height: 500px; }
        .fav-title { font-size: 24px; font-weight: bold; margin-bottom: 30px; border-bottom: 2px solid #1a1a1a; padding-bottom: 10px; }
        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px; }
        .product-card { background-color: #fff; border: 1px solid #e0e0e0; border-radius: 6px; overflow: hidden; position: relative; transition: transform 0.2s; }
        .product-card:hover { transform: translateY(-5px); }
        .product-img-wrapper { width: 100%; padding-top: 100%; position: relative; background-color: #f5f5f5; }
        .product-img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; }
        .product-info { padding: 15px; text-decoration: none; color: inherit; display: block; }
        .product-name { font-size: 14px; font-weight: bold; margin: 0 0 10px 0; height: 40px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .product-price { font-size: 15px; font-weight: bold; color: #1a1a1a; }
        .remove-fav-btn { position: absolute; top: 10px; right: 10px; background-color: rgba(255,255,255,0.9); border: none; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 16px; color: #e53935; box-shadow: 0 2px 5px rgba(0,0,0,0.1); z-index: 5; }
        .empty-message { text-align: center; padding: 80px 0; color: #888; font-size: 16px; }

        /* 💡 追加：レイアウトとフッターの横並びを完全に維持する設定 */
        .product-card {
            display: inline-block;
            width: 100%;
            box-sizing: border-box;
        }
        
        footer, .footer {
            clear: both;
            width: 100%;
        }

        /* 💡 ここから下を追加してください */
        .product-card {
            z-index: 1; /* ベースとなる階層を設定 */
        }

        .product-info {
            position: relative;
            z-index: 2; /* リンクの階層をボタンより下にする */
        }

        .remove-fav-btn {
            z-index: 10 !important; /* 「✕」ボタンを確実に一番手前に浮かせる */
        }
    </style>
</head>
<body>

<?= view('header')->render() ?>

<div class="fav-container">
    <h1 class="fav-title">お気に入り商品</h1>
    
    @if($favorites->isEmpty())
    <div class="empty-message">
        <p>お気に入り登録された商品はありません。</p>
        <a href="/" style="color: #1a1a1a; font-weight: bold;">ショッピングを続ける →</a>
    </div>
@else
    <div class="product-grid">
        @foreach($favorites as $fav)
            {{-- $fav 自体が商品の情報を持っているので「->product」は不要になります --}}
            <div class="product-card" id="fav-card-{{ $fav->id }}">
                <button class="remove-fav-btn" data-id="{{ $fav->id }}" title="お気に入りから削除">✕</button>
                
                <a href="{{ route('products.show', $fav->id) }}" class="product-info">
                    <div class="product-img-wrapper">
                        {{-- 画像パスの判定もシンプルになります --}}
                        @if(!empty($fav->image_path))
                            <img src="{{ asset('storage/' . $fav->image_path) }}" class="product-img">
                        @else
                            <img src="{{ asset('images/no-image.png') }}" class="product-img">
                        @endif
                    </div>
                    <div class="product-info-body" style="padding-top: 10px;">
                        <h3 class="product-name">{{ $fav->product_name }}</h3>
                        <div class="product-price">¥{{ number_format($fav->price) }}</div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    // お気に入り一覧画面での削除処理
    document.querySelectorAll('.remove-fav-btn').forEach(btn => {
        btn.onclick = function(e) {
            e.preventDefault();  // 💡 詳細画面への遷移を確実にブロック
            e.stopPropagation(); // 💡 親のカード要素にクリックイベントが染み出すのを完全にストップ
            
            const productId = this.dataset.id;
            
            fetch('/favorite/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'removed') {
                    // 画面からカードをシュッと消去する効果
                    const card = document.getElementById(`fav-card-${productId}`);
                    card.style.transition = 'all 0.3s ease';
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        card.remove();
                        // 1つもなくなったらリロードして空メッセージを出す
                        if (document.querySelectorAll('.product-card').length === 0) {
                            location.reload();
                        }
                    }, 300); // 💡 スムーズにアニメーションさせるため3000msから300msに調整しました
                }
            })
            .catch(err => console.error("エラーが発生しました:", err));
        };
    });
});
</script>

<?= view('footer')->render() ?>

</body>
</html>