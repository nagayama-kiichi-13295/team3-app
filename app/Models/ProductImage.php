<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product; // ← ★これ追加（重要）

class ProductImage extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'image_path',
        'is_main',
        'display_order'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}