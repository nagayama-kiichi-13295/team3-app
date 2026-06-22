<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- コントローラ ---
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AddressController;

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

// アカウントサービス(ハブ画面)
Route::get('/account', [AccountController::class, 'index']);

// アカウント情報変更
Route::get('/account/edit', [AccountController::class, 'edit']);
Route::post('/account/update', [AccountController::class, 'update']);

// パスワード変更
Route::get('/account/security', [AccountController::class, 'security']);
Route::get('/account/password', [AccountController::class, 'editPassword']);
Route::post('/account/password', [AccountController::class, 'updatePassword']);

// 住所
Route::get('/account/addresses', [AddressController::class, 'index']);
Route::get('/account/addresses/create', [AddressController::class, 'create']);
Route::post('/account/addresses', [AddressController::class, 'store']);
Route::get('/account/addresses/{id}/edit', [AddressController::class, 'edit']);
Route::post('/account/addresses/{id}', [AddressController::class, 'update']);
Route::post('/account/addresses/{id}/delete', [AddressController::class, 'destroy']);


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