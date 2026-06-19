<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スニーカー販売サイト</title>
    
    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family: sans-serif;
            background:#f5f5f5;
        }

        header{
            background:white;
            padding:15px 30px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            box-shadow:0 2px 5px rgba(0,0,0,0.1);
        }

        .logo{
            font-size:28px;
            font-weight:bold;
            color:#ff5a5f;
        }

        .menu a{
            text-decoration:none;
            color:black;
            margin-left:20px;
        }

        .search-area{
            width:80%;
            margin:30px auto;
        }

        .search-area input{
            width:100%;
            padding:15px;
            border-radius:8px;
            border:1px solid #ccc;
        }

        .banner{
            width:80%;
            margin:20px auto;
            background:#222;
            color:white;
            text-align:center;
            padding:60px;
            border-radius:10px;
        }

        .product-list{
            width:80%;
            margin:30px auto;
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:20px;
        }

        .card{
            background:white;
            border-radius:10px;
            overflow:hidden;
            box-shadow:0 2px 8px rgba(0,0,0,0.1);
            cursor:pointer;
            transition:0.2s;
        }

        .card:hover{
            transform: scale(1.02);
        }

        .image{
            height:220px;
            background:#ddd;
        }

        .card-body{
            padding:15px;
        }

        .price{
            color:red;
            font-weight:bold;
            margin-top:10px;
        }

    </style>

</head>
<body>

<?= view('header') -> render() ?>

<div class="search-area">

    <input type="text" placeholder="商品名を検索">

</div>

<div class="banner">

    <h1>人気スニーカー特集</h1>
    <p>限定モデル続々入荷中！</p>

</div>

<div class="product-list">

<?php

$products = [

    [
        "name" => "Air Jordan 1",
        "price" => "35,000円"
    ],

    [
        "name" => "Dunk Low",
        "price" => "22,000円"
    ],

    [
        "name" => "New Balance 990",
        "price" => "28,000円"
    ],

    [
        "name" => "Yeezy Boost",
        "price" => "42,000円"
    ]

];

foreach($products as $product){

?>

    <div class="card">

        <div class="image"></div>

        <div class="card-body">

            <h3><?= htmlspecialchars($product["name"]) ?></h3>

            <div class="price">
                <?= htmlspecialchars($product["price"]) ?>
            </div>

        </div>

    </div>

<?php } ?>

</div>

</body>
</html>