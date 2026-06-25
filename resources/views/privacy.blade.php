<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>プライバシーポリシー</title>
    <style>

body {
    margin: 0;              /* ←これ重要 */
    font-family: Arial, sans-serif;
    line-height: 1.8;
    background-color: #eee; /* サイトと馴染む */
}

.container {
    max-width: 900px;       /* ←これが一番重要 */
    margin: 40px auto;      /* ←中央寄せ */
    background: #fff;
    padding: 30px;
    border-radius: 10px;
}

    </style>
</head>
<body>

@include('header')

<div class="container">
    <h1>プライバシーポリシー</h1>

    <p>当サイト（スニーカー販売サイト）は、ユーザーの個人情報の重要性を認識し、その保護に努めます。</p>

    <h2>1. 個人情報の取得</h2>
    <p>当サイトでは、商品購入やお問い合わせの際に、氏名、住所、電話番号、メールアドレスなどの個人情報を取得する場合があります。</p>

    <h2>2. 利用目的</h2>
    <ul>
        <p>商品の発送および代金の請求</p>
        <p>お問い合わせ対応</p>
        <p>サービス向上のための分析</p>
    </ul>

    <h2>3. 第三者提供</h2>
    <p>法令に基づく場合を除き、本人の同意なく第三者に提供しません。</p>

    <h2>4. 安全管理</h2>
    <p>個人情報の漏えい防止のため、適切な管理を行います。</p>

    <h2>5. Cookieについて</h2>
    <p>当サイトではサービス向上のためCookieを使用する場合があります。</p>

    <h2>6. ポリシーの変更</h2>
    <p>本ポリシーは必要に応じて変更されます。</p>

    <h2>7. お問い合わせ</h2>
    <p>メール: ki-tisyatyodayo@gmail.com</p>
</div>

@include('footer')

</body>
</html>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プライバシーポリシー | Sneaker Market</title>
    
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Helvetica Neue", Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.8;
        }
        .legal-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 40px;
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }
        .legal-title {
            font-size: 24px;
            font-weight: bold;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 30px;
            text-align: center;
        }
        .legal-date {
            text-align: right;
            font-size: 13px;
            color: #999;
            margin-bottom: 20px;
        }
        .legal-section-title {
            font-size: 18px;
            font-weight: bold;
            background-color: #f5f5f5;
            padding: 8px 15px;
            border-left: 4px solid #333;
            margin-top: 40px;
            margin-bottom: 15px;
        }
        .legal-text {
            font-size: 15px;
            margin-bottom: 15px;
        }
        .legal-list {
            padding-left: 20px;
            margin-bottom: 15px;
        }
        .legal-list li {
            font-size: 14px;
            margin-bottom: 8px;
        }
        @media (max-width: 768px) {
            .legal-container { margin: 20px 15px; padding: 20px; }
            .legal-title { font-size: 20px; }
        }
    </style>
</head>
<body>

<?= view('header')->render() ?>

<div class="legal-container">
    <div class="legal-date">改定日：2026年6月24日</div>
    <h1 class="legal-title">プライバシーポリシー</h1>
    
    <p class="legal-text">
        Sneaker Market（以下、「当サイト」といいます。）は、本ウェブサイト上で提供するサービス（以下、「本サービス」といいます。）における、ユーザーの個人情報の取扱いについて、以下のとおりプライバシーポリシー（以下、「本ポリシー」といいます。）を定めます。
    </p>

    <h2 class="legal-section-title">第1条（個人情報の収集方法）</h2>
    <p class="legal-text">
        当サイトは、ユーザーが利用登録をする際に氏名、生年月日、住所、電話番号、メールアドレス、クレジットカード番号などの個人情報をお尋ねすることがあります。また、ユーザーと提携先などとの間でなされたユーザーの個人情報を含む取引記録や決済に関する情報を、当サイトの提携先などから収集することがあります。
    </p>

    <h2 class="legal-section-title">第2条（個人情報を収集・利用する目的）</h2>
    <p class="legal-text">当サイトが個人情報を収集・利用する目的は、以下のとおりです。</p>
    <ul class="legal-list">
        <li>当サイトのサービスの提供・運営のため</li>
        <li>ユーザーからのお問い合わせに回答するため（本人確認を行うことを含む）</li>
        <li>ユーザーが利用中のサービスの更新情報、キャンペーン等及び当サイトが提供する他のサービスの案内メールを送付するため</li>
        <li>メンテナンス、重要なお知らせなど必要に応じたご連絡のため</li>
        <li>利用規約に違反したユーザーや、不正・不当な目的でサービスを利用しようとするユーザーの特定をおこない、利用をお断りするため</li>
    </ul>

    <h2 class="legal-section-title">第3条（個人情報の第三者提供）</h2>
    <p class="legal-text">
        当サイトは、次に掲げる場合を除いて、あらかじめユーザーの同意を得ることなく、第三者に個人情報を提供することはありません。ただし、個人情報保護法その他の法令で認められる場合を除きます。
    </p>
</div>

<?= view('footer')->render() ?>

</body>
</html>