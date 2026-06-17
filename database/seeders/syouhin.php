<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ユーザー
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // 商品データ
        DB::table('products')->insert([
            [
                'name' => 'Off-White × Nike Air Force 1 Low "Black"',
                'price' => 82500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '商品B',
                'price' => 2000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '商品C',
                'price' => 1500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'name' => '商品C',
                'price' => 1500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'name' => '商品C',
                'price' => 1500,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);

        // 商品画像データ
        DB::table('product_images')->insert([
            [
                'product_id' => 1,
                'image_path' => 'images/product1_main.jpg',
                'is_main' => true,
                'display_order' => 1,
            ],
            [
                'product_id' => 1,
                'image_path' => 'images/product1_sub.jpg',
                'is_main' => false,
                'display_order' => 2,
            ],
            [
                'product_id' => 2,
                'image_path' => 'images/product2_main.jpg',
                'is_main' => true,
                'display_order' => 1,
            ],
            [
                'product_id' => 3,
                'image_path' => 'images/product3_main.jpg',
                'is_main' => true,
                'display_order' => 1,
            ],
        ]);
    }
}
