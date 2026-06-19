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
}