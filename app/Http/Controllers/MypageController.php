<?php

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
    }
}