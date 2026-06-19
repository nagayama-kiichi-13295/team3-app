<?php

use Illuminate\Support\Facades\Route;

// --- 6.18ルート追加 ---
use App\Http\Controllers\AuthController;

use App\Http\Controllers\MypageController;

use App\Http\Controllers\BuyController;

// ログイン画面(表示)
Route::get('login', [AuthController::class, 'showLogin']);
// ログイン処理
Route::post('/login', [AuthController::class, 'login']);
// ログアウト
Route::post('/logout', [AuthController::class, 'logout']);

// 新規登録(表示と処理)
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/register/confirm', [AuthController::class, 'confirmRegister']);

// マイページ
Route::get('/mypage', [MypageController::class, 'show']);

// カート(仮ページ/ログイン必須)
Route::get('/cart', function(){
    if (!Auth::check()){
        return redirect('/login');
    }
    return view('cart');
});
//--- 6.18 ここまで追加 ---

// トップページ
Route::get('/', function () {
    return view('home');
});


Route::get('/purchase/confirm', function () {
    return view('buyfrom');
});

Route::post('/kakunin', [BuyController::class, 'confirm']);
