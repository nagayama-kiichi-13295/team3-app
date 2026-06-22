<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model {
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'postal_code',
        'address',
        'phone_number',
    ];
}