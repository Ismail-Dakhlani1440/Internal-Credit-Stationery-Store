<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductOrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('orders',  OrderController::class);