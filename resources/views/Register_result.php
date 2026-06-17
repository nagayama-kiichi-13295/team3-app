<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>登録結果</title>
</head>
<body>

<h1>登録結果</h1>

<?php

$name = $_POST["name"] ?? "";
$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";

if ($name === "" || $email === "" || $password === "") {

    echo "未入力の項目があります";

} else {

    echo "登録完了！<br>";
    echo "名前：" . htmlspecialchars($name) . "<br>";
    echo "メール：" . htmlspecialchars($email);

}

?>

</body>
</html>