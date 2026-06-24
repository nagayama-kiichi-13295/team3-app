<?php /** @var \Illuminate\Pagination\LengthAwarePaginator $products */ ?>
<?php /** @var \Illuminate\Support\Collection|\App\Models\Category[] $categories */ ?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>検索結果</title>
    <link rel="stylesheet" href="/css/search.css">
</head>
<body>
<?= view('header')->render() ?>
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

        <div class="search-body">

        <!-- 左：絞り込みサイドバー -->
            <aside class="search-sidebar">

                <form action="/search" method="get">

                    <!-- 今の検索条件を保持 -->
                    <input type="hidden" name="keyword" value="<?= htmlspecialchars($keyword ?? '') ?>">
                    <input type="hidden" name="sort" value="<?= htmlspecialchars($sort ?? '') ?>">

                    <div class="filter-block">    
                        <h3>カテゴリ</h3>
                        <select name="category">
                            <option value="">すべて</option>
<?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat->id ?>" <?= (string)$categoryId === (string)$cat->id ? 'selected' : '' ?>>
<?= htmlspecialchars($cat->category_name) ?>
                            </option>
<?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-block">
                        <h3>価格</h3>

                        <div class="price-range">
                            <input type="number" name="min_price" placeholder="下限" min="0"
                                value="<?= htmlspecialchars($minPrice ?? '') ?>">

                            <span>〜</span>

                            <input type="number" name="max_price" placeholder="上限" min="0"
                                value="<?= htmlspecialchars($maxPrice ?? '') ?>">
                        </div>

                        <div class="price-presets">
                            <button type="button" onclick="setPrice('', 50000)">〜50,000円</button>
                            <button type="button" onclick="setPrice(20000, 400000)">20,000〜40,000円</button>
                            <button type="button" onclick="setPrice(30000, 50000)">30,000〜50,000円</button>
                            <button type="button" onclick="setPrice(30000, '')">30,000円〜</button>
                        </div>
                    </div>

                    <button type="submit" class="apply-btn">この条件で絞り込む</button>
                </form>
            </aside>

            <!-- 右：検索結果 -->
            <main class="search-main">

            <!-- 並び替え -->
            <form class="sort-bar" action="/search" method="get">
                <input type="hidden" name="keyword" value="<?= htmlspecialchars($keyword ?? '') ?>">
                <input type="hidden" name="category" value="<?= htmlspecialchars($categoryId ?? '') ?>">
                <input type="hidden" name="min_price" value="<?= htmlspecialchars($minPrice ?? '') ?>">
                <input type="hidden" name="max_price" value="<?= htmlspecialchars($maxPrice ?? '') ?>">

                <select name="sort" onchange="this.form.submit()">
                    <option value="">新着順</option>
                    <option value="price_asc"  <?= $sort === 'price_asc'  ? 'selected' : '' ?>>価格の安い順</option>
                    <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>価格の高い順</option>
                </select>

            </form>
<?php if ($products->isEmpty()): ?>
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
                    <div class="product-price">¥<?= number_format($product->price) ?></div>
                    <div class="card-rating">
<?php if ($product->reviews_count > 0): ?>
                        ★ <?= round($product->reviews_avg_star, 1) ?>(<?= $product->reviews_count ?>)
<?php else: ?>
                        <span class="no-rating">レビューなし</span>
<?php endif; ?>
                    </div>
                </a>
<?php endforeach; ?>
            </div>
<div class="pagination"><?= $products->links() ?></div>
<?php endif; ?>
        </main>
    </div>
    <p class="back"><a href="/">トップに戻る</a></p>
</div>

<script>
   // 価格プリセットのボタンで下限・上限欄を埋める
   function setPrice(min, max) {
       document.querySelector('input[name="min_price"]').value = min;
       document.querySelector('input[name="max_price"]').value = max;
   }
</script>
</body>
</html>