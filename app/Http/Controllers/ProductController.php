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
        $products = Product::with('mainImage')->get();

        return view('products.index', compact('products'));
    }

    /**
     * 商品詳細ページ
     */
    public function show($id)
    {
        $product = Product::with('images')->findOrFail($id);

        return view('products.show', compact('product'));
    }
}