<?php
$products = [
    1 => [
        "name" => "Air Jordan 1",
        "price" => "35,000円",
        "desc" => "マイケル・ジョーダンの初代シグネチャーモデルとして歴史に名を刻む一足。ストリートファッションのアイコンとして、今なお世界中で絶大な人気を誇ります。"
    ],
    2 => [
        "name" => "Dunk Low",
        "price" => "22,000円",
        "desc" => "クラシックなシルエットと豊富なカラーバリエーションが魅力の定番モデル。スケートボードカルチャーとも深く結びつき、幅広い層から支持されています。"
    ],
    3 => [
        "name" => "New Balance 990",
        "price" => "28,000円",
        "desc" => "「1000点満点中990点」という挑戦的なキャッチコピーで誕生した名作。卓越したクッション性と安定性、 tender な履き心地が特徴です。"
    ],
    4 => [
        "name" => "Yeezy Boost",
        "price" => "42,000円",
        "desc" => "独特の近未来的デザインと、極上の履き心地を提供するBOOSTフォームを搭載。スニーカーシーンに一石を投じたプレミアムな一足です。"
    ]
];

// URLパラメータ「?id=〇〇」からIDを取得し、そのまま商品データを呼び出し
$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$product = $products[$id];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product["name"], ENT_QUOTES, 'UTF-8') ?> | スニーカー詳細</title>
</head>
<body>

    <div>
        <a href="home.php">← スニーカー一覧へ戻る</a>
    </div>

    <hr>

    <div class="product-image-area">
        [ <?= htmlspecialchars($product["name"], ENT_QUOTES, 'UTF-8') ?> の画像 ]
    </div>

    <div class="product-main-header">
        <h1><?= htmlspecialchars($product["name"], ENT_QUOTES, 'UTF-8') ?></h1>
        
        <button type="button" onclick="alert('お気に入りに追加しました')">
            ♥ お気に入りに追加
        </button>
    </div>

    <hr>

    <div class="description-area">
        <h3>商品説明</h3>
        <p><?= nl2br(htmlspecialchars($product["desc"], ENT_QUOTES, 'UTF-8')) ?></p>
    </div>

    <hr>

    <div class="cart-action">
        <button type="button" onclick="alert('カートに追加しました！')">
            カートに追加する
        </button>
    </div>
<?= view('footer')->render() ?>
</body>
</html>