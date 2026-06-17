<?php

use Illuminate\Support\Facades\Route;

// トップページ
Route::get('/', function () {
    return view('home');
});

// 注文確認
Route::post('/kakunin', function () {

    $name = request('name');
    $email = request('email');
    $tel = request('tel');
    $address = request('address');
    $payment = request('payment');

    // ✅ カート追加（ここが必要）
    $cart = [
        ["name" => "Off-White × Nike Air Force 1 Low Black", "price" => 82500, "qty" => 1]
    ];

    // ✅ 合計計算
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['qty'];
    }

    // ✅ Viewに全部渡す
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