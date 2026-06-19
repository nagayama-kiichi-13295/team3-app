<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- コントローラ ---
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\ProductController;

// --------------------
// 認証系
// --------------------
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

// --------------------
// マイページ
// --------------------
Route::get('/mypage', [MypageController::class, 'show']);

// --------------------
// カート（ログインチェック）
// --------------------
Route::get('/cart', function () {
    if (!Auth::check()) {
        return redirect('/login');
    }
    return view('cart');
});

// --------------------
// ✅ トップページ（ここ修正）
// --------------------
Route::get('/', [ProductController::class, 'index']);

// 商品詳細
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// --------------------
// 購入関連
// --------------------
Route::get('/purchase/confirm', function () {
    return view('buyfrom');
});

Route::post('/kakunin', [BuyController::class, 'confirm']);
