<?php

use Illuminate\Support\Facades\Route;
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

    $name = request('name');
    $email = request('email');
    $tel = request('tel');
    $address = request('address');
    $payment = request('payment');

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