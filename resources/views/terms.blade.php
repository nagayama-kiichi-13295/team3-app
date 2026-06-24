<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>利用規約 | Sneaker Market</title>
    
    <style>
        /* ページ全体の基本スタイル */
        body {
            margin: 0;
            padding: 0;
            font-family: "Helvetica Neue", Arial, "Hiragino Kaku Gothic ProN", "Hiragino Sans", Meiryo, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.8;
        }

        /* メインコンテンツの外枠 */
        .terms-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 40px;
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        /* メインタイトル */
        .terms-title {
            font-size: 24px;
            font-weight: bold;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 30px;
            text-align: center;
            letter-spacing: 1px;
        }

        /* 導入文・改定日 */
        .terms-lead {
            font-size: 14px;
            color: #666;
            margin-bottom: 30px;
        }
        .terms-date {
            text-align: right;
            font-size: 13px;
            color: #999;
            margin-bottom: 20px;
        }

        /* 各章（第1条など）の見出し */
        .terms-section-title {
            font-size: 18px;
            font-weight: bold;
            background-color: #f5f5f5;
            padding: 8px 15px;
            border-left: 4px solid #333;
            margin-top: 40px;
            margin-bottom: 15px;
        }

        /* 条文のテキスト */
        .terms-text {
            font-size: 15px;
            margin-bottom: 15px;
            padding-left: 5px;
        }

        /* 箇条書き（第2項など）のスタイル */
        .terms-list {
            padding-left: 20px;
            margin-bottom: 15px;
        }
        .terms-list li {
            font-size: 14px;
            margin-bottom: 8px;
            list-style-type: decimal;
        }

        /* レスポンシブ対応（スマホ表示） */
        @media (max-width: 768px) {
            .terms-container {
                margin: 20px 15px;
                padding: 20px;
            }
            .terms-title {
                font-size: 20px;
            }
            .terms-section-title {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

<?= view('header')->render() ?>

<div class="terms-container">
    <div class="terms-date">制定日：2026年6月24日</div>
    <h1 class="terms-title">利用規約</h1>
    
    <p class="terms-lead">
        この利用規約（以下，「本規約」といいます。）は，Sneaker Market（以下，「当サイト」といいます。）が提供するサービス（以下，「本サービス」といいます。）の利用条件を定めるものです。登録ユーザーの皆さま（以下，「ユーザー」といいます。）には，本規約に従って，本サービスをご利用いただきます。
    </p>

    <h2 class="terms-section-title">第1条（適用）</h2>
    <p class="terms-text">
        本規約は，ユーザーと当サイトとの間の本サービスの利用に関わる一切の関係に適用されるものとします。
    </p>

    <h2 class="terms-section-title">第2条（利用登録）</h2>
    <p class="terms-text">
        本サービスにおいては，登録希望者が本規約に同意の上，当サイトの定める方法によって利用登録を申請し，当サイトがこれを承認することによって，利用登録が完了するものとします。
    </p>

    <h2 class="terms-section-title">第3条（売買契約）</h2>
    <p class="terms-text">
        1. 本サービスにおいては，ユーザーが当サイトに対して購入の申し込みをし，当サイトが当該申し込みを承諾した旨の通知を送付した時点で，売買契約が成立するものとします。
    </p>
    <p class="terms-text">
        2. 当サイトは，ユーザーが以下のいずれかの事由に該当する場合には，当該売買契約を解除することができるものとします。
    </p>
    <ul class="terms-list">
        <li>ユーザーが本規約に違反した場合</li>
        <li>届け先不明や長期不在により商品の引き渡しが完了しない場合</li>
        <li>その他，当サイトとユーザーとの信頼関係が損なわれたと認める場合</li>
    </ul>

    <h2 class="terms-section-title">第4条（禁止事項）</h2>
    <p class="terms-text">
        ユーザーは，本サービスの利用にあたり，以下の行為をしてはならないものとします。
    </p>
    <ul class="terms-list">
        <li>法令または公序良俗に違反する行為</li>
        <li>犯罪行為に関連する行為</li>
        <li>当サイトのサーバーまたはネットワークの機能を破壊したり，妨害したりする行為</li>
        <li>当サイトのサービスの運営を妨害するおそれのある行為</li>
        <li>他のユーザーに関する個人情報等を収集または蓄積する行為</li>
        <li>不正アクセスをし，またはこれを試みる行為</li>
        <li>他のユーザーに成りすます行為</li>
    </ul>

    <h2 class="terms-section-title">第5条（免責事項）</h2>
    <p class="terms-text">
        当サイトは、本サービスに事実上または法律上の瑕疵（安全性、信頼性、正確性、完全性、有効性、特定の目的への適合性、セキュリティなどに関する欠陥、エラーやバグ、権利侵害などを含みます。）がないことを明示的にも黙示的にも保証しておりません。
    </p>
</div>

<?= view('footer')->render() ?>

</body>
</html>