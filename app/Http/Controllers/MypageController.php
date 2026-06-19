<?php

<<<<<<< HEAD
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller{
    public function show(){
        // ログインしてなければログイン画面へ追いやる
        if (!Auth::check()) {
            return redirect('/login');
        }

        // ログイン中の本人をビューに渡す
        return view('mypage', ['user' => Auth::user()]);
=======
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
>>>>>>> 4cabaa0dac9b59958012b5be8a881e2905d20c97
    }
}