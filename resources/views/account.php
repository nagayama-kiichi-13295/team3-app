<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>アカウントサービス</title>
    <link rel="stylesheet" href="/css/account_hub.css">
</head>
<body>
<?= view('header') -> render() ?>
<div class="account-hub">
    <h1>アカウントサービス</h1>
    
    <div class="hub-grid">
        <a href="/mypage" class="hub-card">
            <div class="hub-icon">👤</div>
            <div class="hub-text">
                <h2>プロフィール</h2>
                <p>名前やメールアドレスの確認・変更</p>
            </div>
        </a>

        <a href="/account/security" class="hub-card">
            <div class="hub-icon">🔓</div>
            <div class="hub-text">
                <h2>ログインとセキュリティ</h2>
                <p>パスワードの変更などの設定</p>
            </div>
        </a>
        
        <a href="/account/addresses" class="hub-card">
            <div class="hub-icon">📍</div>
            <div class="hub-text">
                <h2>アドレス帳</h2>
                <p>お届け先住所の追加・編集</p>
            </div>
        </a>

        <a href="/account/payment" class="hub-card">
            <div class="hub-icon">💳</div>
            <div class="hub-text">
                <h2>お客様のお支払方法</h2>
                <p>お支払方法の管理</p>
            </div>
        </a>

        <a href="/orders" class="hub-card">
            <div class="hub-icon">📦</div>
            <div class="hub-text">
                <h2>注文履歴</h2>
                <p>過去の注文の確認</p>
            </div>
        </a>
    </div>
</div>

</body>
</html>