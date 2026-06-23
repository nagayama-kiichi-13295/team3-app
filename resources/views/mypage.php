<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マイページ</title>
    <link rel="stylesheet" href="/css/mypage.css">
</head>
<body>

<?= view('header') -> render() ?>

<div class="profile">

<?php /** @var \App\Models\User $user */

use Symfony\Component\VarDumper\Command\Descriptor\HtmlDescriptor;

 ?>

<?php if (session('status')): ?>
    <p class="status"><?= htmlspecialchars(session('status')) ?></p>
<?php endif; ?>
    <div class="profile-head">
        <h1>マイページ</h1>
        <a href="/account/edit" class="edit-btn">編集</a>
    </div>
<?php if (!empty($user->icon_path)): ?>
    <img src="<?= asset('storage/' . $user->icon_path) ?>" class="profile-icon" alt="アイコン">
<?php else: ?>
    <div class="profile-icon-placeholder"><?= htmlspecialchars(mb_substr($user -> user_name, 0, 1)) ?></div>
<?php endif; ?>
    <p>名前：<?= htmlspecialchars($user -> name) ?></p>
    <p>メール：<?= htmlspecialchars($user -> email) ?></p>
</div>

</body>
</html>