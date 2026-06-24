<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

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

    /**
     * 検索結果ページ
     */
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $categoryId = $request->input('category');
        $sort = $request->input('sort');

        $query = Product::with('mainImage');

        // キーワード(商品名の部分一致)
        if (!empty($keyword)) {
            $query->where('product_name', 'like', '%' . $keyword . '%');
        }

        // カテゴリー絞り込み
        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        // 並び替え
        if ($sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('id', 'desc'); //新着順(デフォルト)
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('search', [
            'products' => $products,
            'categories' => $categories,
            'keyword' => $keyword,
            'categoryId' => $categoryId,
            'sort' => $sort,
        ]);
    }
}