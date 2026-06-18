<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マイページ</title>

    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            background: #f5f5f5;
        }

        header {
            background: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .logo {
            font-weight: bold;
            font-size: 24px;
            color: #ff4d4d;
        }

        .menu a {
            margin-left: 15px;
            text-decoration: none;
            color: black;
        }

        .profile {
            width: 60%;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<?= view('header') -> render() ?>

<div class="profile">

<?php /** @var \App\Models\User $user */ ?>

<h1>マイページ</h1>

<p>名前：<?= htmlspecialchars($user -> name) ?></p>
<p>メール：<?= htmlspecialchars($user -> email) ?></p>

</div>

</body>
</html>