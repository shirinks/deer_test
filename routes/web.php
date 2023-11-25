<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderHistoryController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/home');
});

Auth::routes();

Route::get('/home', [ProductController::class, 'index'])->name('home');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

Route::middleware(['auth'])->group(function () {
    Route::get('/products/{product}/addToCart', [ProductController::class, 'addToCart'])->name('products.addToCart');
    Route::get('/cart', function () {return view('cart');})->name('cart.view');

    Route::put('/cart/{product}/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/{product}/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/updateTotalAmount', [CartController::class, 'updateTotalAmount'])->name('cart.updateTotalAmount');

    Route::get('/checkout', function () {return view('checkout');})->name('chekout.view');
    Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');

    Route::get('/order-summary', [OrderController::class, 'viewOrderSummary'])->name('summary.view');
    Route::get('/order-history', [OrderHistoryController::class, 'index'])->name('order.history');
});