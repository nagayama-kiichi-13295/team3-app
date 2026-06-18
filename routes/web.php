<?php

use Illuminate\Support\Facades\Route;

// --- 6.18ルート追加 ---
use App\Http\Controllers\AuthController;

use App\Http\Controllers\MypageController;

// ログイン画面(表示)
Route::get('login', [AuthController::class, 'showLogin']);
// ログイン処理
Route::post('/login', [AuthController::class, 'login']);
// ログアウト
Route::post('/logout', [AuthController::class, 'logout']);

// 新規登録(表示と処理)
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

// マイページ
Route::get('/mypage', [MypageController::class, 'show']);

// カート(仮ページ)
Route::get('/cart', function(){
    return view('cart');
});
//--- 6.18 ここまで追加 ---


// トップページ
Route::get('/', function () {
    return view('home');
});

// 注文確認
Route::post('/kakunin', function () {

    $name = request('name');
    $email = request('email');
    $tel = request('tel');
    $address = request('address');
    $payment = request('payment');

    // ✅ カート追加（ここが必要）
    $cart = [
        ["name" => "Off-White × Nike Air Force 1 Low Black", "price" => 82500, "qty" => 1]
    ];

    // ✅ 合計計算
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['qty'];
    }

    // ✅ Viewに全部渡す
    return view('kakunin', compact(
        'name',
        'email',
        'tel',
        'address',
        'payment',
        'cart',
        'total'
    ));
});