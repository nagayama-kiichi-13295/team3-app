<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage; // ← ★これ追加

class Product extends Model
{
    protected $fillable = ['name', 'price'];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function mainImage()
    {
        return $this->hasOne(ProductImage::class)
            ->where('is_main', true);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // 平均星(レビューがなければ0)
    public function averageRating()
    {
        return round($this->reviews()->avg('star'), 1);
    }

    // レビュー件数
    public function reviewCount()
    {
        return $this->reviews()->count();
    }
}