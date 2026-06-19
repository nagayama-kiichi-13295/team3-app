<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
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
=======
use Illuminate\Support\Facades\DB;

// ✅ トップページ（ここに追加する）
Route::get('/', function () {

    $products = DB::table('products')
        ->leftJoin('product_images', 'products.id', '=', 'product_images.product_id')
        ->select('products.*', 'product_images.image_path as image')
        ->where('product_images.is_main', true)
        ->get();

    return view('home', compact('products'));
});


// ✅ 注文確認
Route::post('/kakunin', function () {
>>>>>>> 4cabaa0dac9b59958012b5be8a881e2905d20c97

// 商品詳細
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

<<<<<<< HEAD
// --------------------
// 購入関連
// --------------------
Route::get('/purchase/confirm', function () {
    return view('buyfrom');
});

Route::post('/kakunin', [BuyController::class, 'confirm']);
=======
    // カート
    $cart = [
        ["name" => "Off-White × Nike Air Force 1 Low Black", "price" => 82500, "qty" => 1]
    ];

    // 合計
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['qty'];
    }

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
>>>>>>> 4cabaa0dac9b59958012b5be8a881e2905d20c97
