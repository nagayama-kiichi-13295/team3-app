<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>LOGIN</title>

    <link rel="stylesheet" href="/css/login.css">
</head>

<body>

<?php /** @var \Illuminate\Support\ViewErrorBag $errors */ ?>


<!-- ヘッダー -->
<?= view('header')->render() ?>

<div class="wrapper">

    <!-- 左 -->
    <div class="left">
        <h1>SNKR MKT</h1>
        <p>ENTER THE SYSTEM</p>
    </div>

    <!-- 右 -->
    <div class="right">
        <div class="container">

            <?php /** @var \Illuminate\Support\ViewErrorBag $errors */ ?>

            <h2>LOGIN</h2>


            <form action="/login" method="post">
                <?= csrf_field() ?>

                <input type="email" name="email" placeholder="Enter your email" value="<?= old('email') ?>">
                
                <div class="password-box">
                    <input type="password" id="password" name="password" placeholder="Enter your password">
                    <span class="toggle" onclick="togglePassword()">👁</span>
                </div>

                <div class="terms-area">
                    <button type="button" class="terms-open" onclick="openTerms()">利用規約を読む</button>
                    <label class="terms-check">
                        <input type="checkbox" id="agree" name="agree" disabled onchange="onAgreeChange()">
                        <span id="agreeLabel">利用規約を最後まで読むと同意できます。</span>
                    </label>
                </div>

                <button type="submit" id="loginBtn" disabled>ENTER</button>
            </form>

            <?php if ($errors->any()): ?>
                <p class="error"><?= $errors->first() ?></p>
            <?php endif; ?>

            <div class="footer">
                <p>NO ACCOUNT?</p>
                <a href="/register">SIGN UP</a>
            </div>

        </div>
    </div>
</div>


<div class="terms-overlay" id="termsOverlay">
    <div class="terms-modal">
        <h2>利用規約</h2>

        <div class="terms-body" id="termsBody">
            <!-- ==================================================================== -->
            <!-- ▼▼▼ 利用規約の本文はこの中に書いてね ▼▼▼ -->
            <p>第1条 ダミーテキスト。ダミーテキスト。ダミーテキスト。ダミーテキスト</p>
            <p>第2条 ダミーテキスト。ダミーテキスト。ダミーテキスト。ダミーテキスト</p>
            <p>第3条 ダミーテキスト。ダミーテキスト。ダミーテキスト。ダミーテキスト</p>
            <p>第4条 ダミーテキスト。ダミーテキスト。ダミーテキスト。ダミーテキスト</p>
            <p>第5条 ダミーテキスト。ダミーテキスト。ダミーテキスト。ダミーテキスト</p>
            <p>第6条 ダミーテキスト。ダミーテキスト。ダミーテキスト。ダミーテキスト</p>
            <p>第7条 ダミーテキスト。ダミーテキスト。ダミーテキスト。ダミーテキスト</p>
            <p>第8条 ダミーテキスト。ダミーテキスト。ダミーテキスト。ダミーテキスト</p>
            <p>第9条 ダミーテキスト。ダミーテキスト。ダミーテキスト。ダミーテキスト</p>
            <p>第10条 ダミーテキスト。ダミーテキスト。ダミーテキスト。ダミーテキスト</p>
            <p>第11条 ダミーテキスト。ダミーテキスト。ダミーテキスト。ダミーテキスト</p>
            <p>第12条 ダミーテキスト。ダミーテキスト。ダミーテキスト。ダミーテキスト</p>
            <p>第13条 ダミーテキスト。ダミーテキスト。ダミーテキスト。ダミーテキスト</p>
            <p>第14条 ダミーテキスト。ダミーテキスト。ダミーテキスト。ダミーテキスト</p>
            <p>第15条 ダミーテキスト。ダミーテキスト。ダミーテキスト。ダミーテキスト</p>
            <p>第16条 ダミーテキスト。ダミーテキスト。ダミーテキスト。ダミーテキスト</p>
            <p>第17条 ダミーテキスト。ダミーテキスト。ダミーテキスト。ダミーテキスト</p>
            <p>第18条 ダミーテキスト。ダミーテキスト。ダミーテキスト。ダミーテキスト</p>
            <p>第19条 ダミーテキスト。ダミーテキスト。ダミーテキスト。ダミーテキスト</p>
            <p>第20条 ダミーテキスト。ダミーテキスト。ダミーテキスト。ダミーテキスト</p>
        </div>
        <p class="terms-hint" id="termsHint">※ 最後まで読むと同意できます。</p>

        <button type="button" class="terms-close" onclick="closeTerms()">閉じる</button>
    </div>
</div>


<script>
    function togglePassword() {
        const password = document.getElementById("password");

        if (password.type === "password") {
            password.type = "text";
        } else {
            password.type = "password";
        }
    }

    function openTerms() {
        document.getElementById('termsOverlay').style.display = 'flex';
        const body = document.getElementById('termsBody');
        if (body.scrollHeight <= body.clientHeight + 5) {
            enableAgree();
        }
    }

    function closeTerms() {
        document.getElementById('termsOverlay').style.display = 'none';
    }

    document.getElementById('termsBody').addEventListener('scroll', function () {
        const reachedBottom = this.scrollTop + this.clientHeight >= this.scrollHeight - 5;
        if (reachedBottom) {
            enableAgree();
        }
    });

    function enableAgree() {
        document.getElementById('agree').disabled = false;
        document.getElementById('agreeLabel').textContent = '利用規約に同意する';
        document.getElementById('termsHint').textContent = '✓ 最後まで読みました。「閉じる」で同意にチェックできます';
    }

    function onAgreeChange() {
        document.getElementById('loginBtn').disabled = !document.getElementById('agree').checked;
    }
</script>

</body>
</html>