<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- コントローラ ---
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AddressController;

// --- モデル ---
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Address;


/*
|--------------------------------------------------------------------------
| 認証
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/register/confirm', [AuthController::class, 'confirmRegister']);
Route::post('/register/back', [AuthController::class, 'backRegister']);



// --------------------
// マイページ (注文履歴)
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

// 郵便番号->住所検索
Route::get('/api/zipcode', [AddressController::class, 'lookupZip']);

// --------------------
// カート
// --------------------
Route::get('/cart', function () {
    return view('cart');
})->middleware('auth');

/*
|--------------------------------------------------------------------------
| トップ・商品
|--------------------------------------------------------------------------
*/
Route::get('/', [ProductController::class, 'index']);

Route::get('/products/{id}', [ProductController::class, 'show'])
    ->name('products.show');


/*
|--------------------------------------------------------------------------
| カート表示
|--------------------------------------------------------------------------
*/
Route::get('/cart', function () {

    if (!Auth::check()) {
        return redirect('/login');
    }

    $cart = session()->get('cart', []);
    $cartItems = [];
    $totalPrice = 0;

    if (!empty($cart)) {
        $products = Product::with('mainImage')->find(array_keys($cart));

        foreach ($products as $product) {
            $quantity = $cart[$product->id];
            $subtotal = $product->price * $quantity;
            $totalPrice += $subtotal;

            $cartItems[] = [
                'product' => $product,
                'quantity' => $quantity
            ];
        }
    }

    return view('cart', [
        'cartItems' => $cartItems,
        'totalPrice' => $totalPrice
    ]);
});


/*
|--------------------------------------------------------------------------
| カート操作
|--------------------------------------------------------------------------
*/

// ✅ カート追加（非同期）
Route::post('/cart/add', function (Request $request) {

    if (!Auth::check()) {
        return response()->json([
            'success' => false,
            'message' => 'ログインが必要です'
        ], 401);
    }

    $productId = $request->input('product_id');
    $cart = session()->get('cart', []);

    if (isset($cart[$productId])) {
        $cart[$productId]++;
    } else {
        $cart[$productId] = 1;
    }

    session()->put('cart', $cart);

    return response()->json([
        'success' => true,
        'message' => 'カートに追加しました！'
    ]);
});


// ✅ 数量更新
Route::patch('/cart/update/{id}', function (Request $request, $id) {

    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        $cart[$id] = max(1, (int)$request->input('quantity'));
        session()->put('cart', $cart);
    }

    return redirect('/cart');

})->name('cart.update');


// ✅ 削除
Route::delete('/cart/remove/{id}', function ($id) {

    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }

    return redirect('/cart');

})->name('cart.remove');


/*
|--------------------------------------------------------------------------
| 購入フロー
|--------------------------------------------------------------------------
*/

// ✅ 購入入力画面（住所チェック付き）
Route::get('/purchase/form', function (Request $request) {

    if (!Auth::check()) {
        return redirect('/login');
    }

    $product = Product::findOrFail($request->product_id);

    // ✅ 住所があるか確認
    $address = Address::where('user_id', auth()->id())->first();

    return view('purchase.form', compact('product', 'address'));

})->name('purchase.form');


// ✅ 注文確定
Route::post('/purchase/complete', function (Request $request) {

    $product = Product::findOrFail($request->product_id);

    // ✅ 住所がまだ無い場合のみ保存
    if (!Address::where('user_id', auth()->id())->exists()) {
        Address::create([
            'user_id' => auth()->id(),
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        ]);
    }

    // ✅ 注文保存
    Order::create([
        'user_id' => auth()->id(),
        'total_amount' => $product->price,
    ]);

    // ✅ カート初期化
    session()->forget('cart');

    return redirect('/mypage')->with('success', '購入完了しました');

})->name('purchase.complete');