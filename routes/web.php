<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;

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
    return view('welcome');
});

Route::prefix('app')
    ->group(function() {
        // Route untuk Dashboard
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');
        
        // Route untuk Barang Masuk dan Manajemen Produk
        Route::prefix('product')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('product.index'); // Tampilkan daftar produk
            Route::post('/store', [ProductController::class, 'store'])->name('product.store'); // Tambah produk
            Route::delete('/{id}', [ProductController::class, 'destroy'])->name('product.destroy'); // Hapus produk
            Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('product.edit'); // Form edit produk
            Route::put('/{id}', [ProductController::class, 'update'])->name('product.update'); // Update produk
        });
    });
