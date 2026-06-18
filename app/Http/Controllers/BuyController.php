<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BuyController extends Controller
{
   public function confirm(Request $request)
{
    $name = $request->name;
    $email = $request->email;
    $tel = $request->tel;
    $address = $request->address;
    $payment = $request->payment;

    // チーム想定のカート
    $cart = [
        [
            'name' => 'Sample Item',
            'price' => 1000,
            'qty' => 1
        ]
    ];

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
}
}