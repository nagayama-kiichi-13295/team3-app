<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    /**
     * 商品一覧ページ
     */
    public function index()
    {
        // メイン画像を一緒に取得
        $products = Product::with('mainImage')->get();

        return view('products.index', compact('products'));
    }

    /**
     * 商品詳細ページ
     */
    public function show($id)
    {
        // 商品 + 全画像取得
        $product = Product::with('images')->findOrFail($id);

        return view('products.show', compact('product'));
    }
}