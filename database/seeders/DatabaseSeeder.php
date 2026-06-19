<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ✅ ユーザー作成（mail → email）
        User::create([
            'user_name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // ✅ Seederまとめて呼ぶ
        $this->call([
            ProductSeeder::class,
            ProductImageSeeder::class,
        ]);
    }
}