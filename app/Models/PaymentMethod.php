<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model {
    protected $fillable = [
        'user_id', 'type',
        'card_brand', 'card_holder',
        'paypay_phone',
    ];
}