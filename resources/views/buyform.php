<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>購入者情報入力</title>
</head>
<body>

<h2>購入者情報入力</h2>

<form action="confirm.php" method="post">
    名前：<br>
    <input type="text" name="name"><br><br>


    電話番号：<br>
    <input type="text" name="tel"><br><br>


    住所：<br>
    <input type="text" name="address"><br><br>

    支払い方法：<br>
    <select name="payment">
        <option value="credit">クレジットカード</option>
        <option value="cash">代金引換</option>
        <option value="bank">銀行振込</option>
    </select><br><br>

    <button type="submit">確認画面へ</button>
</form>

</body>
</html>