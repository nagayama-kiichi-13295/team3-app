<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-brand">
            <a href="/" class="footer-logo">Sneaker Market</a>
            <p class="footer-desc">限定モデルから定番アイテムまで豊富に揃う、スニーカー専門のマーケットプレイス。</p>
        </div>

        <div class="footer-links">
            <div class="footer-nav-col">
                <h4>ショッピング</h4>
                <ul>
                    <li><a href="/">ホーム</a></li>
                    <li><a href="/cart">カートを見る</a></li>
                    <li><a href="/favorites">お気に入り商品</a></li>
                </ul>
            </div>
            <div class="footer-nav-col">
                <h4>サポート</h4>
                <ul>
                    <li><a href="/account">アカウントサービス</a></li>
                    <li><a href="/orders">注文履歴</a></li>
                    <li><a href="/contact">お問い合わせ</a></li>
                </ul>
            </div>
        </div>
    </div>

    <button id="scrollTopBtn" class="scroll-top-btn" aria-label="ページトップへ戻る">▲</button>

    <div class="footer-bottom">
        <div class="footer-legal-links">
            <a href="/terms">利用規約</a>
            <a href="/privacy">プライバシーポリシー</a>
            <a href="/tokushoho">特定商取引法に基づく表記</a>
        </div>
        <p>&copy; 2026 Sneaker Market. All rights reserved.</p>
    </div>
</footer>

<style>
    /* フッター全体のスタイリング */
    .site-footer {
        position: relative; /* 💡 ボタンの配置の基準にするため追加 */
        background-color: #1a1a1a;
        color: #ccc;
        padding: 40px 20px 20px;
        font-family: sans-serif;
        margin-top: 60px;
    }

    /* 💡 ページトップへ戻るボタンのCSS */
    .scroll-top-btn {
        position: absolute;
        top: -25px; /* フッターの上の境界線に少し引っかかるように配置 */
        right: 40px;
        width: 50px;
        height: 50px;
        background-color: #333;
        color: #fff;
        border: 2px solid #1a1a1a;
        border-radius: 50%; /* 丸いボタンにする */
        cursor: pointer;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s, transform 0.2s;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .scroll-top-btn:hover {
        background-color: #555;
        transform: translateY(-3px); /* ホバー時に少し上に浮く演出 */
    }

    /* 既存のスタイル（変更なし） */
    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 30px;
    }
    .footer-brand { flex: 1; min-width: 250px; }
    .footer-logo { font-size: 20px; font-weight: bold; color: #fff; text-decoration: none; letter-spacing: 1px; display: inline-block; margin-bottom: 15px; }
    .footer-desc { font-size: 13px; line-height: 1.6; color: #aaa; }
    .footer-links { display: flex; gap: 50px; flex-wrap: wrap; }
    .footer-nav-col h4 { color: #fff; font-size: 14px; margin-bottom: 15px; }
    .footer-nav-col ul { list-style: none; padding: 0; margin: 0; }
    .footer-nav-col li { margin-bottom: 10px; }
    .footer-nav-col a { color: #aaa; text-decoration: none; font-size: 13px; transition: color 0.2s; }
    .footer-nav-col a:hover { color: #fff; }
    
    /* 💡 変更＆追加：規約リンクと最下部のエリア設定 */
    .footer-bottom { 
        border-top: 1px solid #333; 
        margin-top: 30px; 
        padding-top: 20px; 
        text-align: center; 
    }
    
    .footer-legal-links {
        margin-bottom: 15px; /* コピーライトとの隙間 */
        display: flex;
        justify-content: center;
        gap: 20px; /* リンク同士の横のすき間 */
        flex-wrap: wrap; /* スマホで入り切らない時に折り返す */
    }
    
    .footer-legal-links a {
        color: #888; /* 目立ちすぎない落ち着いたグレー */
        text-decoration: none;
        font-size: 12px;
        transition: color 0.2s;
    }
    
    .footer-legal-links a:hover {
        color: #fff; /* ホバー時に白く光る */
        text-decoration: underline; /* ホバー時に下線をつける */
    }

    .footer-bottom p { font-size: 12px; color: #666; margin: 0; }
    
    @media (max-width: 600px) {
        .footer-container { flex-direction: column; }
        .footer-links { gap: 30px; }
        .scroll-top-btn { right: 20px; } /* スマホの時は少し右端に寄せる */
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const scrollTopBtn = document.getElementById('scrollTopBtn');

    if (scrollTopBtn) {
        scrollTopBtn.addEventListener('click', function() {
            // 画面の一番上（X:0, Y:0）へスムーズにスクロール
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});
</script>