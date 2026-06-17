<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>注文確認</title>
</head>
<body>

<h2>注文確認画面</h2>

<h3>■ 購入者情報</h3>
名前：{{ $name }}<br>
メール：{{ $email }}<br>
電話：{{ $tel }}<br>
住所：{{ $address }}<br>
支払い方法：{{ $payment }}<br>

<h3>■ 注文商品</h3>

<table border="1">
    <tr>
        <th>商品名</th>
        <th>価格</th>
        <th>数量</th>
        <th>小計</th>
    </tr>

@foreach ($cart as $item)
<tr>
    <td>{{ $item['name'] }}</td>
    <td>{{ $item['price'] }}円</td>
    <td>{{ $item['qty'] }}</td>
    <td>{{ $item['price'] * $item['qty'] }}円</td>
</tr>
@endforeach

</table>

<h3>合計金額：{{ $total }}円</h3>

<!-- 注文確定 -->
<form action="/complete" method="post">
    @csrf

    <input type="hidden" name="name" value="{{ $name }}">
    <input type="hidden" name="email" value="{{ $email }}">
    <input type="hidden" name="tel" value="{{ $tel }}">
    <input type="hidden" name="address" value="{{ $address }}">
    <input type="hidden" name="payment" value="{{ $payment }}">

    <button type="submit">注文確定ya</button>
</form>

<button onclick="history.back()">戻る</button>

</body>
</html>
