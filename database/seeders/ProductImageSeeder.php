<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];

        for ($i = 1; $i <= 40; $i++) {
            $data[] = [
                'product_id' => $i,
                'image_path' => "products/imagesproduct{$i}_main.jpg",
                'is_main' => true,
                'display_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('product_images')->insert($data);
    }
}