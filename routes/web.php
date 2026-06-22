<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- コントローラ ---
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\ProductController;

// --------------------
// 認証
// --------------------
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/register/confirm', [AuthController::class, 'confirmRegister']);
Route::post('/register/back', [AuthController::class, 'backRegister']);

// --------------------
// マイページ
// --------------------
Route::get('/mypage', [MypageController::class, 'show'])
    ->middleware('auth');

// --------------------
// カート
// --------------------
Route::get('/cart', function () {
    return view('cart');
})->middleware('auth');

// --------------------
// トップページ
// --------------------
Route::get('/', [ProductController::class, 'index']);

// --------------------
// 商品詳細
// --------------------
Route::get('/products/{id}', [ProductController::class, 'show'])
    ->name('products.show');

// --------------------
// 購入
// --------------------
Route::get('/purchase/confirm', function () {
    return view('buyfrom');
});

Route::post('/kakunin', [BuyController::class, 'confirm']);