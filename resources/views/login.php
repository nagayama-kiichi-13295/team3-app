<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>LOGIN</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial Black', sans-serif;
    background: #000;
    color: #fff;
}

/* ===== ヘッダー ===== */
header {
    background: #000;
    padding: 20px 80px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #222;
}

.logo {
    font-size: 26px;
    letter-spacing: 3px;
}

.logo span {
    color: red;
}

.menu {
    display: flex;
    gap: 30px;
    align-items: center;
}

.menu a {
    text-decoration: none;
    color: #aaa;
    font-size: 14px;
}

.menu a:hover {
    color: red;
}

.menu button {
    background: transparent;
    border: 1px solid red;
    color: red;
    padding: 6px 14px;
    cursor: pointer;
}

.menu button:hover {
    background: red;
    color: #fff;
}

/* ===== レイアウト（重要） ===== */
.wrapper {
    display: flex;
    justify-content: flex-start;   /* 左寄せ */
    align-items: flex-start;
    height: calc(100vh - 80px);
    padding: 120px 0 0 120px;
}

/* ===== ログイン ===== */
.container {
    width: 100%;
    max-width: 600px;
    padding: 60px;
    background: #111;
    border: 1px solid #333;
}

h2 {
    margin-bottom: 40px;
    letter-spacing: 3px;
}

input {
    width: 100%;
    padding: 14px;
    margin-bottom: 25px;
    background: #000;
    border: 1px solid #444;
    color: #fff;
}

input:focus {
    border-color: red;
    outline: none;
}

button {
    width: 100%;
    padding: 14px;
    background: red;
    border: none;
    color: #fff;
    letter-spacing: 2px;
    cursor: pointer;
}

button:hover {
    background: #ff1a1a;
}

.error {
    color: #ff4444;
    margin-top: 10px;
}

.footer {
    margin-top: 30px;
    font-size: 12px;
}

.footer a {
    color: #aaa;
}

.footer a:hover {
    color: red;
}
</style>

</head>

<body>

<!-- ✅ ヘッダーは外に出す -->
<?= view('header')->render() ?>

<!-- ✅ ログイン -->
<div class="wrapper">
    <div class="container">

        <?php /** @var \Illuminate\Support\ViewErrorBag $errors */ ?>

        <h2>LOGIN</h2>

        <form action="/login" method="post">
            <?= csrf_field() ?>

            <input type="email" name="email" placeholder="EMAIL" value="<?= old('email') ?>">
            <input type="password" name="password" placeholder="PASSWORD">

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

</body>
</html>