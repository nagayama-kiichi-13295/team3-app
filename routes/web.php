<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- コントローラ ---
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\ProductController;

// --- モデル（追加） ---
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Address;

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
// 旧購入（そのまま残すならOK）
// --------------------
Route::get('/purchase/confirm', function () {
    return view('buyfrom');
});

Route::post('/kakunin', [BuyController::class, 'confirm']);


// ====================
// ✅ 新・購入フロー（ここが追加）
// ====================

// 入力画面
Route::get('/purchase/form', function (Request $request) {

    $product = Product::findOrFail($request->product_id);

    return view('purchase.form', compact('product'));

})->middleware('auth');


// 注文確定
Route::post('/purchase/complete', function (Request $request) {

    $product = Product::findOrFail($request->product_id);

    // ✅ 住所保存
    Address::create([
        'user_id' => auth()->id(),
        'postal_code' => $request->postal_code,
        'address' => $request->address,
        'phone_number' => $request->phone_number,
    ]);

    // ✅ 注文保存
    Order::create([
        'user_id' => auth()->id(),
        'total_amount' => $product->price,
    ]);

    return redirect('/')->with('success', '購入完了しました');

})->middleware('auth');