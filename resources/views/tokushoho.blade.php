<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>特定商取引法に基づく表記 | Sneaker Market</title>
    <style>
        body {
            font-family: sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: left;
            vertical-align: top;
        }
        th {
            width: 30%;
            background: #f0f0f0;
        }
    </style>
</head>
<body>

<?= view('header')->render() ?>

<div class="container">
    <h1>特定商取引法に基づく表記</h1>

    <table>
        <tr>
            <th>販売事業者</th>
            <td>Sneaker Market</td>
        </tr>
        <tr>
            <th>運営責任者</th>
            <td>永山喜一</td>
        </tr>
        <tr>
            <th>所在地</th>
            <td>東京都 米花町 5丁目39番地</td>
        </tr>
        <tr>
            <th>電話番号</th>
            <td>090-8293-2016</td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td>ki-tisyatyodayo@gmail.com</td>
        </tr>
        <tr>
            <th>販売価格</th>
            <td>各商品ページに記載</td>
        </tr>
        <tr>
            <th>商品代金以外の必要料金</th>
            <td>送料（全国一律13500円）</td>
        </tr>
        <tr>
            <th>支払方法</th>
            <td>
                クレジットカード / Paypay
            </td>
        </tr>
        <tr>
            <th>支払時期</th>
            <td>注文確定時にお支払いが確定します</td>
        </tr>
        <tr>
            <th>商品の引渡時期</th>
            <td>注文確定後、通常15営業日以内に発送</td>
        </tr>
        <tr>
            <th>返品・交換について</th>
            <td>
                商品に欠陥がある場合でも返品できません。<br>
            </td>
        </tr>
        <tr>
            <th>返品送料</th>
            <td>不良品の場合はお客様負担</td>
        </tr>
    </table>
</div>

<?= view('footer')->render() ?>

    </body>
    </html>
