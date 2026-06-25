<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>特定商取引法に基づく表記 | Sneaker Market</title>
    
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Helvetica Neue", Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.8;
        }
        .tokushoho-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 40px;
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }
        .tokushoho-title {
            font-size: 24px;
            font-weight: bold;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 30px;
            text-align: center;
        }
        /* テーブルのスタイリング */
        .tokushoho-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .tokushoho-table th, .tokushoho-table td {
            border: 1px solid #e0e0e0;
            padding: 15px;
            font-size: 14px;
            text-align: left;
        }
        .tokushoho-table th {
            background-color: #f5f5f5;
            width: 30%;
            font-weight: bold;
        }
        @media (max-width: 768px) {
            .tokushoho-container { margin: 20px 15px; padding: 20px; }
            .tokushoho-title { font-size: 20px; }
            .tokushoho-table th, .tokushoho-table td { display: block; width: 100%; box-sizing: border-box; }
            .tokushoho-table th { border-bottom: none; }
        }
    </style>
</head>
<body>

<?= view('header')->render() ?>

<div class="tokushoho-container">
    <h1 class="tokushoho-title">特定商取引法に基づく表記</h1>
    
    <table class="tokushoho-table">
        <tr>
            <th>販売業者</th>
            <td>Sneaker Market 株式会社</td>
        </tr>
        <tr>
            <th>運営責任者</th>
            <td>スニーカー 太郎</td>
        </tr>
        <tr>
            <th>所在地</th>
            <td>〒104-0061 東京都中央区銀座X丁目X-X</td>
        </tr>
        <tr>
            <th>電話番号</th>
            <td>03-XXXX-XXXX（受付時間：平日10:00〜17:00）</td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td>support@sneakermarket.example.com</td>
        </tr>
        <tr>
            <th>販売価格</th>
            <td>各商品ページに表示された価格（消費税込み）に基づきます。</td>
        </tr>
        <tr>
            <th>商品代金以外の必要料金</th>
            <td>配送料：全国一律 550円（税込）。商品合計15,000円以上で送料無料。</td>
        </tr>
        <tr>
            <th>引き渡し時期</th>
            <td>ご注文確定後、3〜5営業日以内に発送いたします。</td>
        </tr>
        <tr>
            <th>お支払方法</th>
            <td>クレジットカード決済、代金引換、コンビニ決済</td>
        </tr>
        <tr>
            <th>返品・交換について</th>
            <td>商品到着後7日以内にご連絡があった場合、未使用品に限り返品・交換を承ります。お客様都合の返品の場合、送料はお客様負担となります。</td>
        </tr>
    </table>
</div>

<?= view('footer')->render() ?>

</body>
</html>