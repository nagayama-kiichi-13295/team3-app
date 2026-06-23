<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // 1〜19個目: category_id => 1
            [
                'category_id' => 1,
                'product_name' => '【CONVERSE】ALL STAR Ⓡ HI 
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【mobus】BASEL
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【DC Shoes】DC SCORE
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【New Balance】W996 
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【SOARHOPE】ホワイトスニーカー',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【adidas】SAMBA OG',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【WIMBLEDON】テニスシューズ
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【adidas】グランドコートベース 2.0Ｍ
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【mobus】MELNIK
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【KAMIYA】Joey
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【CONVERSE】ネクスター110 OX
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【YOOCOYA】キッズスニーカー',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【bope】レディーススニーカー
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【FILA】Balena
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【Taobao】肉球靴
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【ZKGK】ダンススニーカー
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【ゴールデンベア】カジュアルスニーカー
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【ORiental TRaffic】キルティングデザインスニーカー
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => '【=Me】ME-3797
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 20〜40個目（下から21個分）: category_id => 2
            [
                'category_id' => 2,
                'product_name' => '【YOKUNERU】ブラックTシャツ
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【FUZHIHUA】七分丈シャツ Blue
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【FUZHIHUA】七分丈シャツ Black
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【VERAVANT】トレーナー
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【TRAVAS TOKYO】パンダパーカー
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【Sukinana】ブラックパーカー
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【Uptoyou】レイヤードトレーナー',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【STARZORA】青パーカー
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【Kayiyasu】火ダウン
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【Almalls】ヴィンテージTシャツ
',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '【長袖】Tシャツ',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'product_name' => '',
                'description' => '',
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Product::insert($data);
    }
}