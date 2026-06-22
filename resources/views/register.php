<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>REGISTER</title>
<link rel="stylesheet" href="/css/login.css">
</head>
<body>
<?= view('header')->render() ?>
<?php /** @var \Illuminate\Support\ViewErrorBag $errors */ ?>
<div class="wrapper">
<!-- 左 -->
<div class="left">
<h1>SNKR MKT</h1>
<p>JOIN THE SYSTEM</p>
</div>
<!-- 右 -->
<div class="right">
<div class="container">
<h2>REGISTER</h2>
<?php if ($errors->any()): ?>
<ul class="error">
<?php foreach ($errors->all() as $error): ?>
<li><?= htmlspecialchars($error) ?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<form action="/register/confirm" method="POST">
<?= csrf_field() ?>
<input type="text" name="user_name" placeholder="USERNAME"
                   value="<?= old('user_name') ?>">
<input type="email" name="email" placeholder="EMAIL"
                   value="<?= old('email') ?>">
<!-- パスワード（目アイコンで表示切替） -->
<div class="password-box">
<input type="password" id="password" name="password" placeholder="PASSWORD"
                       value="<?= old('password') ?>">
<span class="toggle" onclick="togglePassword()">👁</span>
</div>
<button type="submit">確認画面へ</button>
</form>
<div class="footer">
<p>ALREADY HAVE ACCOUNT?</p>
<a href="/login">LOGIN</a>
</div>
</div>
</div>
</div>
<!-- JS -->
<script>
function togglePassword() {
   const pw = document.getElementById("password");
   pw.type = (pw.type === "password") ? "text" : "password";
}
</script>
</body>
</html>