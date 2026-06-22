<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Address extends Model
{
    protected $table = 'addresses';

    protected $fillable = [
        'user_id',
        'postal_code',
        'address',
        'phone_number',
    ];

    // ✅ ユーザーとの関係
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}