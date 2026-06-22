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


                <button type="submit">ENTER</button>
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
<script>
function togglePassword() {
    const password = document.getElementById("password");

    if (password.type === "password") {
        password.type = "text";
    } else {
        password.type = "password";
    }
}
</script>

</body>
</html>