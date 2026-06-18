<?php

use Illuminate\Support\Facades\Route;

// --- 6.18ルート追加 ---
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

// =========================
// 認証系
// =========================

// ログイン画面(表示)
Route::get('/login', [AuthController::class, 'showLogin']);

// 新規登録(表示と処理)
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);


// =========================
// 商品一覧（ホーム）
// =========================

// ★ここを変更（重要）
// もともとの view('home') を Controllerに変更
Route::get('/', [ProductController::class, 'index']);


// =========================
// 商品詳細ページ
// =========================

Route::get('/products/{id}', [ProductController::class, 'show'])
    ->name('products.show');


// =========================
// 注文確認
// =========================

Route::post('/kakunin', function () {

    $name = request('name');
    $email = request('email');
    $tel = request('tel');
    $address = request('address');
    $payment = request('payment');

    // ✅ カート（仮データ）
    $cart = [
        [
            "name" => "Off-White × Nike Air Force 1 Low Black",
            "price" => 82500,
            "qty" => 1
        ]
    ];

    // ✅ 合計
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['qty'];
    }

    // ✅ Viewへ
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



