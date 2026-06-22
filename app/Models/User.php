<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * ✅ DBに合わせる（ここ重要）
     */
    protected $fillable = [
        'user_name',
        'email',
        'password',
    ];

    /**
     * ✅ 不要なやつ削除
     */
    protected $hidden = [
        'password',
    ];

    /**
     * ✅ 不要なcasts削除
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}