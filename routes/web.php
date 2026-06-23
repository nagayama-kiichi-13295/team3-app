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
use App\Models\OrderItem; // ✅ 追加
use App\Models\Address;
use App\Models\Favorite;


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
| マイページ
|--------------------------------------------------------------------------
*/
Route::get('/mypage', [MypageController::class, 'show'])
    ->middleware('auth');


/*
|--------------------------------------------------------------------------
| 商品
|--------------------------------------------------------------------------
*/
Route::get('/', [ProductController::class, 'index']);

Route::get('/products/{id}', function ($id) {

    $product = Product::with('images')->findOrFail($id);

    $isFavorite = false;

    if (Auth::check()) {
        $isFavorite = Favorite::where('user_id', auth()->id())
            ->where('product_id', $id)
            ->exists();
    }

    return view('products.show', compact('product', 'isFavorite'));

})->name('products.show');


/*
|--------------------------------------------------------------------------
| カート
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

    return view('cart', compact('cartItems', 'totalPrice'));
});


/*
|--------------------------------------------------------------------------
| カート操作
|--------------------------------------------------------------------------
*/

// ✅ 追加
Route::post('/cart/add', function (Request $request) {

    if (!Auth::check()) {
        return response()->json([
            'redirect' => '/login'
        ], 401);
    }

    $productId = $request->product_id;
    $quantity = max(1, (int)$request->quantity);

    $cart = session()->get('cart', []);
    $cart[$productId] = ($cart[$productId] ?? 0) + $quantity;

    session()->put('cart', $cart);

    return response()->json([
        'success' => true,
        'message' => $quantity . '個 カートに追加しました！'
    ]);
});


// ✅ 更新
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
| お気に入り
|--------------------------------------------------------------------------
*/
Route::post('/favorite/toggle', function (Request $request) {

    if (!Auth::check()) {
        return response()->json([
            'redirect' => '/login'
        ], 401);
    }

    $favorite = Favorite::where('user_id', auth()->id())
        ->where('product_id', $request->product_id)
        ->first();

    if ($favorite) {
        $favorite->delete();
        return response()->json(['status' => 'removed']);
    }

    Favorite::create([
        'user_id' => auth()->id(),
        'product_id' => $request->product_id
    ]);

    return response()->json(['status' => 'added']);
});


/*
|--------------------------------------------------------------------------
| ✅ 購入フロー（完全版）
|--------------------------------------------------------------------------
*/

// ✅ 入力
Route::get('/purchase/form', function (Request $request) {

    if (!Auth::check()) return redirect('/login');

    $product = Product::findOrFail($request->product_id);
    $address = Address::where('user_id', auth()->id())->first();

    return view('purchase.form', compact('product', 'address'));

})->name('purchase.form');


// ✅ 確認
Route::post('/purchase/buyconfirm', function (Request $request) {

    $request->validate([
        'postal_code' => 'required',
        'address' => 'required',
        'phone_number' => 'required',
        'payment_method' => 'required',
        'quantity' => 'required|integer|min:1'
    ]);

    $product = Product::findOrFail($request->product_id);

    return view('purchase.buyconfirm', [
        'product' => $product,
        'data' => $request->all()
    ]);

})->name('purchase.buyconfirm');


// ✅ ✅ ✅ 完了（order_items対応版）
Route::post('/purchase/complete', function (Request $request) {

    $product = Product::findOrFail($request->product_id);
    $quantity = max(1, (int)$request->quantity);

    // ✅ 住所保存
    if (!Address::where('user_id', auth()->id())->exists()) {
        Address::create([
            'user_id' => auth()->id(),
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        ]);
    }

    // ✅ 合計
    $total = $product->price * $quantity;

    // ✅ 注文作成
    $order = Order::create([
        'user_id' => auth()->id(),
        'total_amount' => $total,
    ]);

    // ✅ ✅ 商品内容保存（ここが重要）
    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'quantity' => $quantity,
        'unit_price' => $product->price
    ]);

    // ✅ カート削除
    session()->forget('cart');

    return view('purchase.complete', compact('total'));

})->name('purchase.complete');