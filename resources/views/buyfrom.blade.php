<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>購入者情報入力画面</title>
</head>
<body>

<h2>購入者情報入力</h2>

    <form method="POST" action="/kakunin">
    @csrf

    <p>名前：<input type="text" name="name"></p>
    <p>メール：<input type="email" name="email"></p>
    <p>電話：<input type="text" name="tel"></p>
    <p>住所：<input type="text" name="address"></p>

    <select name="payment">
        <option value="credit">クレカ</option>
        <option value="cash">代引き</option>
        <option value="bank">銀行</option>
    </select>

    <button type="submit">確認</button>
</form>

</body>
</html>