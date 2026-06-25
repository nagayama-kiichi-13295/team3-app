<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // ✅ カート表示
    public function index()
    {
        $cart = session('cart', []);
        $cartItems = [];

        $totalPrice = 0;

        foreach ($cart as $id => $item) {

            // Productを取得（表示用）
            $product = Product::find($id);

            if (!$product) continue;

            $cartItems[] = [
                'product' => $product,
                'quantity' => $item['quantity']
            ];

            $totalPrice += $product->price * $item['quantity'];
        }

        return view('cart', compact('cartItems', 'totalPrice'));
    }

    // ✅ カート追加
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $cart = session('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
        } else {
            $cart[$id] = [
                'quantity' => 1
            ];
        }

        session(['cart' => $cart]);

        return redirect('/cart');
    }

    // ✅ 数量更新（←これが超重要🔥）
    public function update(Request $request, $id)
    {
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = (int)$request->quantity;
        }

        session(['cart' => $cart]);

        return redirect()->back();
    }

    // ✅ 削除
    public function remove($id)
    {
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        session(['cart' => $cart]);

        return redirect()->back();
    }
}