<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// コントローラ
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\PaymentController;

use App\Http\Controllers\ContactController;

// モデル 
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\Favorite;
use App\Models\Review;


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


/*
|--------------------------------------------------------------------------
| マイページ
|--------------------------------------------------------------------------
*/
Route::get('/mypage', [MypageController::class, 'show'])
    ->middleware('auth');


/*
|--------------------------------------------------------------------------
| アカウント
|--------------------------------------------------------------------------
*/
Route::get('/account', [AccountController::class, 'index']);
Route::get('/account/edit', [AccountController::class, 'edit']);
Route::post('/account/update', [AccountController::class, 'update']);

Route::get('/account/security', [AccountController::class, 'security']);
Route::get('/account/password', [AccountController::class, 'editPassword']);
Route::post('/account/password', [AccountController::class, 'updatePassword']);

Route::get('/account/addresses', [AddressController::class, 'index']);
Route::get('/account/addresses/create', [AddressController::class, 'create']);
Route::post('/account/addresses', [AddressController::class, 'store']);
Route::get('/account/addresses/{id}/edit', [AddressController::class, 'edit']);
Route::post('/account/addresses/{id}', [AddressController::class, 'update']);
Route::post('/account/addresses/{id}/delete', [AddressController::class, 'destroy']);

Route::get('/api/zipcode', [AddressController::class, 'lookupZip']);


/*
|--------------------------------------------------------------------------
| 商品一覧（閲覧履歴表示）
|--------------------------------------------------------------------------
*/
Route::get('/', function () {

    $products = Product::with('mainImage')
        ->withCount('reviews')
        ->withAvg('reviews', 'star')
        ->paginate(12); // get() -> paginate(12)

    // ✅ 閲覧履歴取得
    $viewedIds = session()->get('viewed_products', []);
    $viewedProducts = Product::with('mainImage')
        ->whereIn('id', $viewedIds)
        ->get()
        ->sortBy(function ($p) use ($viewedIds) {
            return array_search($p->id, $viewedIds); // セッションの並び順(最近見た順)
        })
        ->values();
    return view('products.index', compact('products', 'viewedProducts'));
});

/*
|--------------------------------------------------------------------------
| 検索バー
|--------------------------------------------------------------------------
*/
Route::get('/search', [ProductController::class, 'search']) -> name('search');

/*
|--------------------------------------------------------------------------
| 商品詳細（閲覧履歴保存）
|--------------------------------------------------------------------------
*/
Route::get('/products/{id}', function ($id) {

    $product = Product::with('images')->findOrFail($id);

    // ✅ 閲覧履歴保存
    $viewed = session()->get('viewed_products', []);
    $viewed = array_diff($viewed, [$id]);
    array_unshift($viewed, $id);
    $viewed = array_slice($viewed, 0, 15);
    session()->put('viewed_products', $viewed);

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
| ✅ 閲覧履歴ページ（ここ追加）
|--------------------------------------------------------------------------
*/
Route::get('/history', function () {

    if (!Auth::check()) return redirect('/login');

    $viewedIds = session()->get('viewed_products', []);
    $viewedProducts = Product::whereIn('id', $viewedIds)->get();

    return view('history', compact('viewedProducts'));

})->name('history');


/*
|--------------------------------------------------------------------------
| ✅ 注文履歴
|--------------------------------------------------------------------------
*/
Route::get('/orders', function () {

    if (!Auth::check()) return redirect('/login');

    $orders = Order::with('orderItems.product.mainImage')
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('orders', compact('orders'));

})->name('orders');


/*
|--------------------------------------------------------------------------
| レビュー投稿
|--------------------------------------------------------------------------
*/
Route::post('/products/{id}/review', function (Request $request, $id) {
    
    if (!Auth::check()) return redirect('/login');

    $request->validate([
        'star' => 'required|integer|between:1,5',
        'comment' => 'nullable|max:1000',
    ], [
        'star.required' => '星の数を選んでください。',
    ]);

    // 同じ人の同じ省へのレビューは上書き
    Review::updateOrCreate(
        ['user_id' => auth()->id(), 'product_id' => $id],
        ['star' => $request->star, 'comment' => $request->comment]
    );

    return redirect('/products/' . $id)->with('status', 'レビューを投稿しました。');
    
})->name('review.store');


/*
|--------------------------------------------------------------------------
| カート表示
|--------------------------------------------------------------------------
*/
Route::get('/cart', function () {

    if (!Auth::check()) return redirect('/login');

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
Route::post('/cart/add', function (Request $request) {

    if (!Auth::check()) {
        return response()->json(['redirect' => '/login'], 401);
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


Route::patch('/cart/update/{id}', function (Request $request, $id) {
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        $cart[$id] = max(1, (int)$request->input('quantity'));
        session()->put('cart', $cart);
    }

    return redirect('/cart');
})->name('cart.update');


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
        return response()->json(['redirect' => '/login'], 401);
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
| 購入フロー
|--------------------------------------------------------------------------
*/
Route::get('/purchase/form', function (Request $request) {

    if (!Auth::check()) return redirect('/login');

    $product = Product::findOrFail($request->product_id);
    $address = Address::where('user_id', auth()->id())->first();

    // 登録済みお支払方法を取得
    $payments = \App\Models\PaymentMethod::where('user_id', auth() -> id())
        -> orderBy('id', 'desc')
        -> get();

    return view('purchase.form', compact('product', 'address', 'payments'));

})->name('purchase.form');


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


Route::post('/purchase/complete', function (Request $request) {

    $product = Product::findOrFail($request->product_id);
    $quantity = max(1, (int)$request->quantity);

    if (!Address::where('user_id', auth()->id())->exists()) {
        Address::create([
            'user_id' => auth()->id(),
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        ]);
    }

    $total = $product->price * $quantity;

    $order = Order::create([
        'user_id' => auth()->id(),
        'total_amount' => $total,
    ]);

    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'quantity' => $quantity,
        'unit_price' => $product->price
    ]);

    session()->forget('cart');

    return view('purchase.complete', compact('total'));

})->name('purchase.complete');


/*
|--------------------------------------------------------------------------
| 支払方法
|--------------------------------------------------------------------------
*/
Route::get('/account/payment', [PaymentController::class, 'index']);
Route::get('/account/payment/create', [PaymentController::class, 'create']);
Route::post('/account/payment', [PaymentController::class, 'store']);
Route::post('/account/payment/{id}/delete', [PaymentController::class, 'destroy']);
/*
|--------------------------------------------------------------------------
|お問い合わせ
|--------------------------------------------------------------------------
*/
Route::get('/contact', function () {
   return view('contact');
});
Route::post('/contact/send', [ContactController::class, 'send'])
   ->name('contact.send');

   Route::view('/terms', 'terms');