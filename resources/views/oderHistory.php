<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>注文履歴</title> 
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
<link rel="stylesheet" href="{{ asset('css/order.css') }}">
</head>

<body>
<?= view('header') -> render() ?>

<div class="cart-container">
    <h1>注文履歴</h1>

    @if(empty($orders) || count($orders) == 0)
        <div class="empty-cart">
            <p>注文履歴がありません。</p>
            <a href="/" class="back-btn">← 商品一覧に戻る</a>
        </div>
    @else
        <div class="order-history-list">
            @foreach($orders as $order)
                <div class="order-block" style="border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin-bottom: 30px; background-color: #fff;">
                    
                    <div class="order-header" style="border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                        <div>
                            <span style="font-weight: bold; margin-right: 20px;">注文日: {{ $order->created_at->format('Y年m月d日 H:i') }}</span>
                            <span>注文番号: <strong style="color: #555;">{{ $order->order_number }}</strong></span>
                        </div>
                        <div style="font-weight: bold; color: #e44d26;">
                            合計金額: {{ number_format($order->total_price) }}円(税込)
                        </div>
                    </div>

                    <div class="order-items">
                        @foreach($order->orderItems as $item)
                        <div class="cart-item" style="border-bottom: 1px solid #eee; padding: 10px 0; display: flex; align-items: center; justify-content: space-between;">
                            
                            <div class="item-image">
                                @if($item->product->mainImage && $item->product->mainImage->image_path)
                                    <img src="{{ asset('storage/' . $item->product->mainImage->image_path) }}" alt="{{ $item->product->product_name }}" style="width: 100px; height: 100px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('images/no-image.png') }}" alt="No Image" style="width: 100px; height: 100px; object-fit: cover;">
                                @endif
                            </div>

                            <div class="item-details" style="flex: 1; margin-left: 20px;">
                                <h3 style="margin: 0 0 5px 0; font-size: 1.1rem;">{{ $item->product->product_name }}</h3>
                                <p class="item-price" style="margin: 0; color: #666;">単価: {{ number_format($item->price) }}円</p>
                            </div>

                            <div class="item-actions" style="text-align: right; min-width: 120px;">
                                <p style="margin: 0 0 5px 0;">数量: <strong>{{ $item->quantity }}</strong></p>
                                <p style="margin: 0; font-weight: bold;">小計: {{ number_format($item->price * $item->quantity) }}円</p>
                            </div>

                        </div>
                        @endforeach
                    </div>

                </div>
            @endforeach
        </div>

        <div style="margin-top: 20px; text-align: center;">
            <a href="/" class="back-btn" style="display: inline-block; padding: 10px 20px; background: #eee; color: #333; text-decoration: none; border-radius: 4px;">ショッピングを続ける</a>
        </div>
    @endif
</div>

</body>
</html>