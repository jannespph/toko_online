<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;

use App\Http\Controllers\Seller\DashboardController as SellerDashboard;
use App\Http\Controllers\Seller\ProductController as SellerProductController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\CategoryController;

use Illuminate\Support\Facades\Route;

// ─── PUBLIC — Tanpa middleware, siapapun bisa akses ─────────────────────

// Home
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

// Katalog produk
Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');

// Detail produk berdasarkan slug
// Laravel otomatis mencari product WHERE slug = nilai URL
Route::get('/products/{product:slug}', [ProductController::class, 'show'])
    ->name('products.show');


// ─── BUYER ───────────────────────────────────────────────────────────────

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [OrderController::class, 'dashboard'])
        ->name('dashboard');
});


// ─── SELLER ──────────────────────────────────────────────────────────────

Route::middleware(['auth', 'role:seller'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {

        Route::get('/dashboard', [SellerDashboard::class, 'index'])
            ->name('dashboard');

        Route::resource('products', SellerProductController::class);
    });


// ─── ADMIN ───────────────────────────────────────────────────────────────

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboard::class, 'index'])
            ->name('dashboard');

        Route::resource('categories', CategoryController::class);
    });


// ─── PROFILE ─────────────────────────────────────────────────────────────

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';