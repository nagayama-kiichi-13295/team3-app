<?php

use Illuminate\Support\Facades\Route;
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
Route::post('/register/confirm', [AuthController::class, 'confirmRegister']);
Route::post('/register/back', [AuthController::class, 'backRegister']);

// --------------------
// マイページ
// --------------------
Route::get('/mypage', [MypageController::class, 'show']);

// --------------------
// カート（ログインチェック ＆ データ準備）
// --------------------
Route::get('/cart', function () {
    if (!Auth::check()) {
        return redirect('/login');
    }

    // 1. セッションからカートデータを取得
    $cart = session()->get('cart', []);

    $cartItems = [];
    $totalPrice = 0;

    // 2. カートに入っている商品IDをもとに、データベースから商品情報を取得
    if (!empty($cart)) {
        // App\Models\Product はご自身の環境のモデル名に合わせてください
        $products = \App\Models\Product::with('mainImage')->find(array_keys($cart));

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

    // 3. 画面（View）に組み立てたデータを渡して表示
    return view('cart', [
        'cartItems' => $cartItems,
        'totalPrice' => $totalPrice
    ]);
});

// --------------------
// ✅ トップページ（ここ修正）
// --------------------
Route::get('/', [ProductController::class, 'index']);

// 商品詳細
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// --------------------
// 購入関連
// --------------------
Route::get('/purchase/confirm', function () {
    return view('buyfrom');
});

Route::post('/kakunin', [BuyController::class, 'confirm']);

// ==========================================
// 🔥 ここから追記：非同期でのカート追加処理
// ==========================================
Route::post('/cart/add', function (\Illuminate\Http\Request $request) {
    // ログインしていない場合はエラーを返す
    if (!Auth::check()) {
        return response()->json([
            'success' => false,
            'message' => 'ログインが必要です。'
        ], 401);
    }

    $productId = $request->input('product_id');

    // セッションから現在のカートを取得
    $cart = session()->get('cart', []);

    // カートに商品を追加（すでにあれば+1、なければ1個で新規追加）
    if (isset($cart[$productId])) {
        $cart[$productId]++;
    } else {
        $cart[$productId] = 1;
    }

    // セッションに保存
    session()->put('cart', $cart);

    // フロント（JavaScript）に成功を返す
    return response()->json([
        'success' => true,
        'message' => 'カートに商品を追加しました！'
    ]);
});

// ==========================================
// 💡 カート画面の「更新」「削除」「購入手続き」のルートを追加
// ==========================================

// 1. カート内商品の数量更新
Route::patch('/cart/update/{id}', function (\Illuminate\Http\Request $request, $id) {
    $cart = session()->get('cart', []);
    if (isset($cart[$id])) {
        $cart[$id] = max(1, (int)$request->input('quantity')); // 1未満にならないように制限
        session()->put('cart', $cart);
    }
    return redirect('/cart')->with('success', 'カートを更新しました');
})->name('cart.update');

// 2. カート内商品の削除
Route::delete('/cart/remove/{id}', function ($id) {
    $cart = session()->get('cart', []);
    if (isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }
    return redirect('/cart')->with('success', '商品を削除しました');
})->name('cart.remove');

// 3. 購入手続きへ進む（※とりあえずトップや確認画面へ流す、または現在のbuyfromを表示）
Route::get('/checkout', function () {
    return view('buyfrom');
})->name('checkout');