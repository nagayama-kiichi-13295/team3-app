<?php

class MypageController
{
    public function show()
    {
        // 後でDBから取得する予定
        $user = [
            'name' => '山田太郎',
            'email' => 'test@example.com',
            'profile' => 'PHPを勉強中です'
        ];

        include __DIR__ . '/../views/mypage.php';
    }
}