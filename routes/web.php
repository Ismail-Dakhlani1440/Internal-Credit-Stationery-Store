<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductOrderController;

Route::get('/', [ProductController::class, 'index']);

Route::resource('products', ProductController::class);

Route::get('/cart', function(){
    return view('cart');
});

Route::resource('orders',  OrderController::class);
