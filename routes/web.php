<?php

use App\Http\Controllers\ProductController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductOrderController;

Route::get('/', [ProductController::class, 'index']);

Route::resource('products', ProductController::class);
Route::get('/', function () {
    return view('welcome');
});

Route::resource('orders',  OrderController::class);
