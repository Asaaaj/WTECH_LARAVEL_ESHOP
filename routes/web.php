<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\PageController;
use App\Http\Controllers\NewProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [PageController::class, 'landingPage'])->name('landing_page');

Route::get('/detail', [PageController::class, 'detail'])->name('detail');
Route::post('/detail', [PageController::class, 'editCartAmount'])->name('cart-items.detail');
Route::post('/detail-session', [PageController::class, 'addToSession'])->name('cart-items.detail-session');

Route::get('/detail/{id}/edit', [PageController::class, 'editProduct'])->name('detail.edit');
Route::put('/detail/{id}', [PageController::class, 'updateProduct'])->name('product.update');
Route::delete('/product/{id}', [PageController::class, 'deleteProduct'])->name('product.delete');
Route::delete('product/{productId}/image/{imageId}', [PageController::class, 'removeImage'])->name('product.removeImage');

Route::get('/new_product_admin', [PageController::class, 'newProductAdmin'])->name('new_product_admin');
Route::post('/new_product_admin', [NewProductController::class, 'newProductAdminPost'])->name('new_product_admin');

Route::get('/payment', [PageController::class, 'payment'])->name('payment');
Route::post('/order_submit', [PageController::class, 'submitOrder'])->name('payment.submit');

Route::match(['get', 'post'], '/order', [PageController::class, 'order'])->name('order');

Route::get('/products', [PageController::class, 'products'])->name('products');

Route::get('/shopping_cart', [PageController::class, 'shoppingCart'])->name('shopping_cart');
Route::put('/cart-items/{id}', [PageController::class, 'updateCartItems'])->name('cart-items.update');
Route::delete('/cart-items/{id}/remove', [PageController::class, 'removeCartItem'])->name('cart-items.remove');


require __DIR__.'/auth.php';
