<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// コントローラ
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MypageController;
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

use App\Models\PaymentMethod;

use PHPUnit\Framework\Constraint\Count;

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
| 商品一覧
|--------------------------------------------------------------------------
*/
Route::get('/', function () {

    $products = Product::with('mainImage')
        ->withCount('reviews')
        ->withAvg('reviews', 'star')
        ->paginate(12); // get() -> paginate(12)
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
| 商品詳細
|--------------------------------------------------------------------------
*/
Route::get('/products/{id}', function ($id) {

    $product = Product::with(['images', 'reviews.user'])->findOrFail($id);

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

    // 関連商品(同じカテゴリ・自分以外)
    $relatedProducts = Product::with('mainImage')
        ->where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->withCount('reviews')
        ->withAvg('reviews', 'star')
        ->take(6)
        ->get();

    // 最近見た商品(今見ている商品は除く)
    $viewedIds = array_values(array_diff($viewed, [$product->id]));
    $viewedProducts = Product::with('mainImage')
        ->whereIn('id', $viewedIds)
        ->get()
        ->sortBy(fn($p) => array_search($p->id, $viewedIds))
        ->values();

    return view('products.show', compact(
        'product', 'isFavorite', 'relatedProducts', 'viewedProducts'
    ));
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
            $totalPrice += $product->price * $quantity;

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
Route::patch('/cart/update/{id}', function (Request $request, $id) {

    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        $cart[$id] = max(1, (int)$request->quantity);
    }

    session()->put('cart', $cart);

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
| ✅ カート追加（これ追加）
|--------------------------------------------------------------------------
*/
Route::post('/cart/add', function (Request $request) {

    // ✅ JSONで受け取る（←これが重要）
    $data = json_decode($request->getContent(), true);

    $productId = $data['product_id'] ?? null;
    $quantity  = (int)($data['quantity'] ?? 1);

    if (!$productId) {
        return response()->json(['message' => '商品IDエラー'], 400);
    }

    if ($quantity < 1) $quantity = 1;

    $cart = session()->get('cart', []);

    // ✅ 既にあれば加算
    if (isset($cart[$productId])) {
        $cart[$productId] += $quantity;
    } else {
        $cart[$productId] = $quantity;
    }

    session()->put('cart', $cart);

    return response()->json([
        'message' => 'カートに追加しました'
    ]);
});


/*
|--------------------------------------------------------------------------
| お気に入り一覧表示（モデル完全不要版）
|--------------------------------------------------------------------------
*/
Route::get('/favorites', function () {
    if (!Auth::check()) return redirect('/login');

    // DBから直接お気に入りデータと商品データを結合（JOIN）して取得します
    $favorites = \Illuminate\Support\Facades\DB::table('favorites')
        ->join('products', 'favorites.product_id', '=', 'products.id')
        ->leftJoin('product_images', function($join) {
            // メイン画像を取得（ここでは最初の1枚、あるいは特定の条件を結合）
            $join->on('products.id', '=', 'product_images.product_id');
        })
        ->where('favorites.user_id', auth()->id())
        ->select('products.*', 'product_images.image_path') // 必要な商品情報と画像パスを抽出
        ->orderBy('favorites.id', 'desc')
        ->get();

    return view('favorites', compact('favorites'));
})->name('favorites.index');


/*
|--------------------------------------------------------------------------
| お気に入り非同期通信（モデル完全不要版）
|--------------------------------------------------------------------------
*/
Route::post('/favorite/toggle', function (\Illuminate\Http\Request $request) {
    if (!Auth::check()) {
        return response()->json(['redirect' => '/login'], 401);
    }

    $userId = auth()->id();
    $productId = $request->input('product_id');

    // DBファサードで直接テーブルからレコードを検索
    $favorite = \Illuminate\Support\Facades\DB::table('favorites')
        ->where('user_id', $userId)
        ->where('product_id', $productId)
        ->first();

    if ($favorite) {
        // すでに登録されていれば削除（DB直接操作なのでfillableエラーは起きません）
        \Illuminate\Support\Facades\DB::table('favorites')
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();
            
        return response()->json(['status' => 'removed']);
    } else {
        // 登録されていなければ新規挿入
        \Illuminate\Support\Facades\DB::table('favorites')->insert([
            'user_id' => $userId,
            'product_id' => $productId,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        return response()->json(['status' => 'added']);
    }
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

    $payments = \App\Models\PaymentMethod::where('user_id', auth()->id())
        ->orderBy('id', 'desc')
        ->get();

    $quantity = $request->input('quantity', 1);

    return view('purchase.form', compact(
        'product',
        'address',
        'payments',
        'quantity'
    ));

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

    $quantity = (int)$request->quantity;
    $total = $product->price * $quantity;

    return view('purchase.buyconfirm', [
        'product' => $product,
        'quantity' => $quantity,
        'total' => $total,
        'data' => $request->all()
    ]);

})->name('purchase.buyconfirm');


Route::post('/purchase/complete', function (Request $request) {

    $product = Product::findOrFail($request->product_id);
    $quantity = max(1, (int)$request->quantity);
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

    return view('purchase.complete', [
        'total' => $total,
        'product' => $product // ✅ これがさっきのエラー修正
    ]);

})->name('purchase.complete');

/*
|--------------------------------------------------------------------------
| 注文履歴
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

/*
|--------------------------------------------------------------------------
| フッターリンク用のルーティング（シンプル版）
|--------------------------------------------------------------------------
*/

// 利用規約 (terms.blade.php)
Route::view('/terms', 'terms')->name('terms');

// プライバシーポリシー (privacy.blade.php)
Route::view('/privacy', 'privacy')->name('privacy');

// 特定商取引法に基づく表記 (tokushoho.blade.php)
Route::view('/tokushoho', 'tokushoho')->name('tokushoho');




Route::get('/orders', function () {

    if (!Auth::check()) return redirect('/login');

    $orders = Order::with('orderItems.product.mainImage')
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('orders', compact('orders'));

})->name('orders');


   
Route::view('/privacy', 'privacy');
Route::view('/tokushoho', 'tokushoho');

Route::get('/payment', function () {
    return view('payment');
})->name('payment.create');


Route::get('/payment', function () {

    $methods = PaymentMethod::where('user_id', Auth::id())->get();

    return view('payment', compact('methods'));

})->name('payment.create');
