<?php /** @var \Illuminate\Pagination\LengthAwarePaginator $products */ ?>
<?php /** @var \Illuminate\Support\Collection|\App\Models\Category[] $categories */ ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>検索結果</title>
    <link rel="stylesheet" href="/css/search.css">
</head>
<body>
<?= view('header')->render() ?>
<?php /** @var \Illuminate\Pagination\LengthAwarePaginator $products */ ?>

<div class="search-page">

    <div class="search-head">
        <h1>
<?php if (!empty($keyword)): ?>
            「<?= htmlspecialchars($keyword) ?>」の検索結果
<?php else: ?>
            商品一覧
<?php endif; ?>
        </h1>
        <span class="result-count"><?= $products->total() ?>件</span>
    </div>

    <!-- 絞り込み・並び替えバー -->
     <form class="filter-bar" action="/search" method="get">
        <input type="hidden" name="keyword" value="<?= htmlspecialchars($keyword ?? '') ?>">

        <select name="category" onchange="this.form.submit()">
            <option value="">すべてのカテゴリ</option>
<?php foreach ($categories as $cat): ?>
            <option value="<?= $cat->id ?>" <?= (string)$categoryId === (string)$cat->id ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat->category_name) ?>
            </option>
<?php endforeach; ?>
        </select>

        <select name="sort" onchange="this.form.submit()">
            <option value="">新着順</option>
            <option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>価格の安い順</option>
            <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>価格の高い順</option>
        </select>
     </form>

     <!-- 商品グリッド -->
<?php if ($products -> isEmpty()): ?>
    <p class="no-result">該当する商品が見つかりませんでした。</p>
<?php else: ?>
    <div class="product-grid">
<?php foreach ($products as $product): ?>
        <a href="/products/<?= $product->id ?>" class="product-card">
            <div class="product-img">
<?php if ($product->mainImage): ?>
                <img src="<?= asset('storage/' . $product->mainImage->image_path) ?>" alt="<?= htmlspecialchars($product->product_name) ?>">
<?php else: ?>
                <div class="no-img">No Image</div>
<?php endif; ?>
            </div>

            <div class="product-name"><?= htmlspecialchars($product->product_name) ?></div>
            <div class="product-price"><?= htmlspecialchars($product->price) ?></div>
        </a>
<?php endforeach; ?>
    </div>

    <!-- ページ送り -->
     <div class="pagination">
        <?= $products->links() ?>
     </div>
<?php endif; ?>
    <p class="back"><a href="/">トップに戻る</a></p>
</div>
</body>
</html>