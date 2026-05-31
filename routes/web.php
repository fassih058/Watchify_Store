<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WatchController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('admin/watches', [WatchController::class, 'index'])->name('admin.watches.index');
    Route::get('admin/watches/add', [WatchController::class, 'add'])->name('admin.watches.add');
    Route::post('admin/watches/store', [WatchController::class, 'store'])->name('admin.watches.store');
    Route::post('admin/watches/delete', [WatchController::class, 'destroy'])->name('admin.watches.delete');
    Route::post('admin/watches/update', [WatchController::class, 'update'])->name('admin.watches.update');
    Route::post('admin/watches/edit', [WatchController::class, 'edit'])->name('admin.watches.edit');

    Route::get('admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::post('admin/orders/details', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::post('admin/orders/update-status', [OrderController::class, 'update'])->name('admin.orders.updateStatus');

    Route::get('/admin/users', [AdminController::class, 'showAllUsers'])->name('admin.users.index');
    Route::post('/admin/users/delete', [AdminController::class, 'destroy'])->name('admin.users.delete');
});

Route::get('/home', [BuyerController::class, 'home'])->name('home');
Route::get('/home/featured', [BuyerController::class, 'featured'])->name('featured');
Route::get('/home/watches', [BuyerController::class, 'details'])->name('watchDetails');
Route::post('/home/watches/review', [ReviewController::class, 'store'])->name('review.store');

Route::get('/home/search', [BuyerController::class, 'search'])->name('search');

Route::get('/home/cart', [BuyerController::class, 'addToCart'])->name('cartDetails');
Route::post('/home/cart', [BuyerController::class, 'addToCart'])->name('addToCart');

Route::get('/home/cart-details', [BuyerController::class, 'cart'])->name('cartItems');
Route::post('/home/cart-details/inc', [BuyerController::class, 'increase'])->name('increase');
Route::post('/home/cart-details/dec', [BuyerController::class, 'decrease'])->name('decrease');
Route::post('/home/cart-details/rem', [BuyerController::class, 'remove'])->name('remove');

Route::get('/home/checkout', [BuyerController::class, 'checkout'])->name('checkout');
Route::post('/home/checkout/placeOrder', [BuyerController::class, 'placeOrder'])->name('placeOrder');

Route::get('/home/about-us', [BuyerController::class, 'aboutUs'])->name('aboutUs');
Route::get('/home/my-orders', [BuyerController::class, 'myOrders'])->name('myOrders');

Route::post('/review/delete', [ReviewController::class, 'delete'])->name('review.delete');

Route::get('/login', [AuthController::class, 'loginForm'])->name('loginForm');
Route::get('/register', [AuthController::class, 'registerForm'])->name('registerForm');

// Admin registration routes (protected by secret key)
Route::get('/admin/register', [AuthController::class, 'adminRegisterForm'])->name('adminRegisterForm');
Route::post('/admin/register', [AuthController::class, 'adminRegister'])->name('adminRegister');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');