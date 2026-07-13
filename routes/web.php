<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Products
Route::get('/shop', [ProductController::class, 'index'])->name('shop');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/category/{slug}', [ProductController::class, 'byCategory'])->name('products.category');
Route::get('/search', [ProductController::class, 'search'])->name('products.search');

// Cart (accessible by guests too)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'addItem'])->name('cart.add');
Route::patch('/cart/{item}', [CartController::class, 'updateItem'])->name('cart.update');
Route::delete('/cart/{item}', [CartController::class, 'removeItem'])->name('cart.remove');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Checkout Flow
    Route::get('/checkout/address', [CheckoutController::class, 'step1'])->name('checkout.address');
    Route::post('/checkout/address', [CheckoutController::class, 'storeAddress'])->name('checkout.address.store');
    Route::get('/checkout/shipping', [CheckoutController::class, 'step2'])->name('checkout.shipping');
    Route::get('/checkout/payment', [CheckoutController::class, 'step3'])->name('checkout.payment');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::delete('/profile/avatar', [ProfileController::class, 'destroyAvatar'])->name('profile.avatar.destroy');

    // Orders
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    Route::get('/profile/orders/{orderNumber}', [ProfileController::class, 'orderDetail'])->name('profile.order.detail');

    // Wishlist
    Route::get('/profile/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Addresses
    Route::get('/profile/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::post('/profile/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::put('/profile/addresses/{id}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/profile/addresses/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::patch('/profile/addresses/{id}/default', [AddressController::class, 'setDefault'])->name('addresses.setDefault');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Laravel Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
