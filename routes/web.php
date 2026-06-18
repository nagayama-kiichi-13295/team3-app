<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuyController;

Route::get('/', function () {
    return view('buyfrom');
});

Route::post('/kakunin', [BuyController::class, 'confirm']);