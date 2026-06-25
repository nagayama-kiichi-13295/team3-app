<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ショッピングカート</title> 
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
</head>

<body>
<?= view('header')->render() ?>

<div class="cart-container">
    <h1>ショッピングカート</h1>

    @if(empty($cartItems) || count($cartItems) == 0)
        <div class="empty-cart">
            <p>カートに商品が入っていません。</p>
            <a href="/" class="back-btn">← 商品一覧に戻る</a>
        </div>
    @else
        <div class="cart-content">
            <div class="cart-items" style="border-bottom: 1px solid #ddd; padding-bottom: 20 px; margin-bottom: 20px;">
                @foreach($cartItems as $item)
                <div class="cart-item">

                    <div class="item-image">
                        @if($item['product']->mainImage && $item['product']->mainImage->image_path)
                            <img src="{{ asset('storage/' . $item['product']->mainImage->image_path) }}" alt="{{ $item['product']->name }}" style="width: 200px; height: 200px; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/no-image.png') }}" alt="No Image" style="width: 100px; height: 100px; object-fit: cover;">
                        @endif
                    </div>

                    <div class="item-details">
                        <h3>{{ $item['product']->product_name }}</h3>
                        <p class="item-price">{{ number_format($item['product']->price) }}円</p>
                    </div>

                    <div class="item-actions">
                        <!-- 数量更新 -->
                        <form action="{{ route('cart.update', $item['product']->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1">
                            <button type="submit" class="btn-update">更新</button>
                        </form>

                        <!-- 削除 -->
                        <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('削除しますか？')">削除</button>
                        </form>
                    </div>

                </div>
                @endforeach
            </div>

            <!-- ✅ 注文内容 -->
            <div class="cart-summary">
               
                <h2>注文内容</h2>

                <div class="summary-row">
                    <span>小計</span>
                    <span>{{ number_format($totalPrice) }}円</span>
                </div>

                <div class="summary-row theme-total">
                    <span>合計金額 (税込)</span>
                    <span class="total-price">{{ number_format($totalPrice) }}円</span>
                </div>

                <!-- ✅ ここが重要（修正ポイント） -->
                @if(!empty($cartItems))
                    <a href="/purchase/form?product_id={{ $cartItems[0]['product']->id }}" class="btn-checkout">
                        購入手続きへ進む
                    </a>
                @endif

                <a href="/" class="btn-continue">ショッピングを続ける</a>

            </div>

        </div>
    @endif
</div>
<div id="eva-bg"></div>

</body>

<script>
window.addEventListener("DOMContentLoaded", () => {
    const btn = document.querySelector(".btn-checkout");
    const parent = document.querySelector(".cart-summary");
 
    let escapeCount = 0;
 
    btn.addEventListener("mouseover", () => {
 
        // 5回までは逃げる
        if (escapeCount < 5) {
            escapeCount++;
 
            const parentRect = parent.getBoundingClientRect();
            const btnWidth = btn.offsetWidth;
            const btnHeight = btn.offsetHeight;
 
            const maxX = parentRect.width - btnWidth;
            const maxY = parentRect.height - btnHeight;
 
            // 現在位置
            let currentX = btn.offsetLeft;
            let currentY = btn.offsetTop;
 
            // ランダム方向
            let moveX = (Math.random() > 0.5 ? 1 : -1) * (50 + Math.random() * 100);
            let moveY = (Math.random() > 0.5 ? 1 : -1) * (50 + Math.random() * 100);
 
            let newX = currentX + moveX;
            let newY = currentY + moveY;
 
            // 範囲内に制限
            newX = Math.max(0, Math.min(maxX, newX));
            newY = Math.max(0, Math.min(maxY, newY));
 
            btn.style.position = "absolute";
            btn.style.left = newX + "px";
            btn.style.top = newY + "px";
 
            // テキスト変更
            btn.textContent = `あと ${5 - escapeCount} 回…`;
 
        } else {
            // 解放
            btn.style.position = "static";
            btn.style.left = "";
            btn.style.top = "";
 
            btn.textContent = "購入手続きへ進む";
        }
    });
});

setInterval(() => {
    document.querySelectorAll('input[type="number"]').forEach(input => {
        if (Math.random() > 0.7) {
            input.value = Math.max(1, parseInt(input.value) + (Math.random() > 0.5 ? 1 : -1));
        }
    });
}, 4000);
setInterval(() => {
    const total = document.querySelector(".total-price");
    if (total) {
        total.textContent = (Math.floor(Math.random()*100000)) + "円";
    }
}, 3000);
window.addEventListener("DOMContentLoaded", () => {

    const words = [
        "襲来", "覚悟", "魂", "選択", "確定", "買いましょう！", "驚安!",
        "男の戦い", "奇跡の価値は", "涙", "決断", "衝撃"
    ];

    const container = document.getElementById("eva-bg");

    function createText() {
        const div = document.createElement("div");
        div.classList.add("eva-text");

        // ランダム単語
        div.textContent = words[Math.floor(Math.random() * words.length)];

        // ランダムサイズ（重要）
        const size = Math.random() * 120 + 40; 
        div.style.fontSize = size + "px";

        // ランダム位置
        div.style.top = Math.random() * 100 + "%";
        div.style.left = Math.random() * 100 + "%";

        // 傾き
        div.style.transform = `rotate(${Math.random()*20 - 10}deg)`;
        div.style.opacity = 1; 

        // 透明度（奥行き）
        div.style.opacity = Math.random() * 0.3 + 0.1;

        // スピード
        const duration = Math.random() * 20 + 10;
        div.style.animationDuration = duration + "s";

        container.appendChild(div);

        // 一定時間で削除
        setTimeout(() => div.remove(), 20000);
    }

    // 定期生成
    setInterval(createText, 800);

});

</script>
</html>