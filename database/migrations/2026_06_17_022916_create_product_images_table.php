<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();

            // ✅ 外部キー制約つける（推奨）
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->string('image_path');

            $table->boolean('is_main')->default(false);

            $table->integer('display_order')->default(1);

            // ✅ これが今回の超重要ポイント
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};