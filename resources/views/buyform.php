<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>確認画面</title>
</head>
<body>

<h2>購入者情報確認</h2>

@if(isset($customer))
    <p>名前：{{ $customer->name }}</p>
@else
    <form method="POST" action="/kakunin">
        @csrf

        <input name="name">
        <input name="email">
        <input name="postal_code">
        <input name="phone_number">
        <input name="address">

        <select name="payment">
            <option value="credit">クレカ</option>
            <option value="cash">代引き</option>
            <option value="bank">銀行</option>
        </select>

        <button>確認</button>
    </form>
@endif

</body>
</html>
