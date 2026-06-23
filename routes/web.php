<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- コントローラ ---
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ProductController;

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


/*
|--------------------------------------------------------------------------
| マイページ（注文履歴）
|--------------------------------------------------------------------------
*/
Route::get('/mypage', [MypageController::class, 'show'])
    ->middleware('auth');


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

// ✅ カート追加（非同期・数量対応・ログインチェック）
Route::post('/cart/add', function (Request $request) {

    // ✅ 未ログイン → ログインへ
    if (!Auth::check()) {
        return response()->json([
            'redirect' => '/login'
        ], 401);
    }

    $productId = $request->input('product_id');
    $quantity = (int) $request->input('quantity', 1);

    $cart = session()->get('cart', []);
    $currentQty = $cart[$productId] ?? 0;

    // ✅ 数量追加
    $cart[$productId] = $currentQty + $quantity;

    session()->put('cart', $cart);

    return response()->json([
        'success' => true,
        'message' => $quantity . '個 カートに追加しました！'
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

// ✅ 購入入力画面
Route::get('/purchase/form', function (Request $request) {

    if (!Auth::check()) {
        return redirect('/login');
    }

    $product = Product::findOrFail($request->product_id);

    $address = Address::where('user_id', auth()->id())->first();

    return view('purchase.form', compact('product', 'address'));

})->name('purchase.form');


// ✅ 注文確定
Route::post('/purchase/complete', function (Request $request) {

    $product = Product::findOrFail($request->product_id);

    // ✅ 住所登録（未登録なら）
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

    // ✅ カートリセット
    session()->forget('cart');

    return redirect('/mypage')->with('success', '購入完了しました');

})->name('purchase.complete');