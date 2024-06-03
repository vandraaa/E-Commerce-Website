<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;

Auth::routes();

Route::get('/', [ProductController::class, 'show_product'])->name('show_product');

Route::middleware(['admin'])->group(function() {
    Route::get('/create-product', [ProductController::class, 'create_product'])->name('create_product');
    Route::post('/create-product', [ProductController::class, 'store_product'])->name('store_product');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit_product'])->name('edit_product');
    Route::patch('/product/{product}/update', [ProductController::class, 'update_product'])->name('update_product');
    Route::delete('/product/{product}/delete', [ProductController::class, 'destroy_product'])->name('destroy_product');

    Route::post('/order/{order}/confirm', [OrderController::class, 'confirm_payment'])->name('confirm_payment');
    Route::post('/order/{order}/shipped', [OrderController::class, 'confirm_shipped'])->name('confirm_shipped');
});

Route::middleware(['member'])->group(function () {
    Route::get('/cart', [CartController::class, 'show_cart'])->name('show_cart');
    Route::post('/cart/{product}', [CartController::class, 'add_to_cart'])->name('add_to_cart');
    Route::patch('/cart/{cart}', [CartController::class, 'update_cart'])->name('update_cart');
    Route::delete('cart/{cart}', [CartController::class, 'delete_cart'])->name('delete_cart');
});

Route::middleware(['auth'])->group(function () {
    Route::get('product/{product}', [ProductController::class, 'show_detail_product'])->name('show_detail_product');

    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('/order', [OrderController::class, 'show_order'])->name('show_order');
    Route::get('/order/{order}', [OrderController::class, 'show_detail_order'])->name('show_detail_order');
    Route::post('/order/{order}/pay', [OrderController::class, 'submit_payment_receipt'])->name('submit_payment_receipt');

    Route::get('/profile', [ProfileController::class, 'show_profile'])->name('show_profile');
    Route::post('/profile', [ProfileController::class, 'edit_profile'])->name('edit_profile');
});


