<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>購入情報入力</title>

<link rel="stylesheet" href="{{ asset('css/form.css') }}">
</head>

<body>

<?= view('header')->render() ?>

<div class="form-container">

    <h2>購入情報入力</h2>

    <!-- ✅ 住所がある場合 -->
    @if(isset($address))

        <div class="saved-address">
            <p>登録済み住所</p>

            <p>{{ $address->postal_code }}</p>
            <p>{{ $address->address }}</p>
            <p>{{ $address->phone_number }}</p>
        </div>

        <form action="{{ route('purchase.complete') }}" method="post">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <button type="submit">この住所で購入</button>
        </form>

    @else

        <!-- ✅ 住所がない場合 -->
        <form action="{{ route('purchase.complete') }}" method="post">
            @csrf

            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <label>郵便番号</label>
            <input type="text" name="postal_code" required>

            <label>住所</label>
            <input type="text" name="address" required>

            <label>電話番号</label>
            <input type="text" name="phone_number" required>

            <button type="submit">注文確定</button>
        </form>

    @endif

</div>

</body>
</html>