<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [];

        for ($i = 1; $i <= 40; $i++) {
            $data[] = [
                'category_id' => 1,
                'product_name' => "スニーカー{$i}",
                'description' => "人気スニーカー No.{$i}",
                'price' => rand(20000, 50000),
                'stock' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Product::insert($data);
    }
}