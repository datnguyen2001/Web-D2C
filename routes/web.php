<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\web\HomeController;
use \App\Http\Controllers\web\CartController;
use \App\Http\Controllers\web\ProductsController;
use \App\Http\Controllers\admin\LoginController;
use \App\Http\Controllers\admin\DashboardController;
use \App\Http\Controllers\ProductController;
use \App\Http\Controllers\OrderController;

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

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('shop/login', [LoginController::class, 'shopLogin'])->name('login');
Route::post('shop/dologin', [LoginController::class, 'shopDoLogin'])->name('shop.doLogin');
Route::get('shop/logout', [LoginController::class, 'shopLogout'])->name('shop.logout');

Route::get('api/detail-product/{slug}', [ProductsController::class, 'detailProduct']);
Route::get('api/get-viewed-products', [ProductsController::class, 'getViewedProducts']);
Route::post('api/favorite-product', [ProductsController::class, 'favoriteProduct']);
Route::get('api/get-favorite-product', [ProductsController::class, 'getFavoriteProducts']);

Route::get('api/get-cart', [CartController::class, 'getCart']);
Route::post('api/add-to-cart', [CartController::class, 'addToCart']);
Route::post('api/remove-product-from-cart', [CartController::class, 'removeProductFromCart']);
Route::post('api/remove-shop-from-cart', [CartController::class, 'removeShopFromCart']);
Route::post('api/update-cart-quantity', [CartController::class, 'updateCartQuantity']);
Route::middleware(['jwt.auth'])->group(function () {
    Route::post('api/buy-now', [CartController::class, 'buyNow']);
    Route::post('api/checkout', [CartController::class, 'checkout']);
    Route::post('api/pay', [CartController::class, 'pay']);
});

Route::middleware('auth')->group(function () {
    Route::get('shop', [DashboardController::class, 'shop'])->name('shop');

    Route::prefix('shop/product')->name('shop.product.')->group(function () {
        Route::get('', [ProductController::class, 'index'])->name('index');
        Route::get('create', [ProductController::class, 'create'])->name('create');
        Route::post('store', [ProductController::class, 'store'])->name('store');
        Route::get('delete/{id}', [ProductController::class, 'delete']);
        Route::get('edit/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [ProductController::class, 'update'])->name('update');
        Route::post('delete-img', [ProductController::class, 'deleteImg']);
        Route::get('delete-price/{id}', [ProductController::class, 'deletePrice']);
        Route::post('variant-price', [ProductController::class, 'variantPrice']);
        Route::get('discount/{id}', [ProductController::class, 'discount']);
        Route::post('update-discount/{id}', [ProductController::class, 'updateDiscount']);
    });

    Route::prefix('shop/order')->name('shop.order.')->group(function (){
        Route::get('index/{status}', [OrderController::class,'getDataOrder'])->name('index');
        Route::get('detail/{id}', [OrderController::class,'orderDetail'])->name('detail');
        Route::get('status/{order_id}/{status_id}', [OrderController::class,'statusOrder'])->name('status');
    });

});
