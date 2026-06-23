<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>注文履歴</title> 
    <link rel="stylesheet" href="{{ asset('css/orders.css') }}">
</head>

<body>
<?= view('header')->render() ?>

<div class="orders-container" style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    <h1>注文履歴</h1>

    @if(empty($orders) || count($orders) == 0)
        <div class="empty-orders" style="text-align: center; padding: 40px;">
            <p>まだ注文履歴がありません。</p>
            <a href="/" class="back-btn" style="display: inline-block; margin-top: 20px;">← 商品一覧に戻る</a>
        </div>
    @else
        <div class="orders-list">
            @foreach($orders as $order)
                <div class="order-card" style="border: 1px solid #ddd; margin-bottom: 30px; border-radius: 8px; overflow: hidden;">
                    
                    <div class="order-header" style="background-color: #f6f6f6; padding: 15px; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; flex-wrap: wrap;">
                        <div>
                            <span style="font-size: 0.85rem; color: #555;">注文日</span><br>
                            <strong>{{ $order->created_at->format('Y年m月d日') }}</strong>
                        </div>
                        <div>
                            <span style="font-size: 0.85rem; color: #555;">合計金額 (税込)</span><br>
                            <strong>{{ number_format($order->total_amount) }}円</strong>
                        </div>
                        <div>
                            <span style="font-size: 0.85rem; color: #555;">注文番号</span><br>
                            <strong>{{ $order->order_number }}</strong>
                        </div>
                    </div>

                    <div class="order-body" style="padding: 20px;">
                        @foreach($order->orderItems as $item)
                            <div class="order-item" style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #eee; padding: 15px 0; margin-bottom: 10px;">
                                
                                <div class="item-image" style="width: 80px; height: 80px; flex-shrink: 0; margin-right: 20px;">
                                    @if($item->product->mainImage && $item->product->mainImage->image_path)
                                        <img src="{{ asset('storage/' . $item->product->mainImage->image_path) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('images/no-image.png') }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @endif
                                </div>

                                <div class="item-details" style="flex-grow: 1;">
                                    <h3 style="margin: 0 0 5px 0; font-size: 1.1rem;">{{ $item->product->product_name }}</h3>
                                    <p class="item-price" style="margin: 0; color: #555;">{{ number_format($item->unit_price) }}円</p>
                                </div>

                                <div class="item-summary" style="text-align: right; min-width: 120px;">
                                    <p style="margin: 0;">数量: {{ $item->quantity }}</p>
                                    <p style="margin: 5px 0 0 0; font-weight: bold;">小計: {{ number_format($item->unit_price * $item->quantity) }}円</p>
                                </div>

                            </div>
                        @endforeach
                    </div>

                </div>
            @endforeach
        </div>
    @endif
</div>

</body>
</html>