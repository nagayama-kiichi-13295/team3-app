<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::insert([
            [
                'category_id' => 1,
                'product_name' => 'Air Jordan 1', // ✅ 修正
                'description' => '人気のスニーカー',
                'price' => 35000,
                'stock' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => 'Dunk Low',
                'description' => '定番モデル',
                'price' => 22000,
                'stock' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => 'New Balance 990',
                'description' => '履き心地抜群',
                'price' => 28000,
                'stock' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'product_name' => 'Yeezy Boost',
                'description' => '高級モデル',
                'price' => 42000,
                'stock' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}