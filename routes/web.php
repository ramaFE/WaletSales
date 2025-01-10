<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SalesController;

// Route untuk Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Route untuk Barang Masuk dan Manajemen Produk
Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product.index'); // Tampilkan daftar produk
    Route::get('/create', [ProductController::class, 'create'])->name('product.create'); // Form tambah produk
    Route::post('/', [ProductController::class, 'store'])->name('product.store'); // Tambah produk
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('product.destroy'); // Hapus produk
    Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('product.edit'); // Form edit produk
    Route::put('/{id}', [ProductController::class, 'update'])->name('product.update'); // Update produk
});

// Route untuk Manajemen Customer
Route::prefix('customer')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customer.index'); // Tampilkan daftar customer
    Route::get('/create', [CustomerController::class, 'create'])->name('customer.create'); // Form tambah customer
    Route::post('/', [CustomerController::class, 'store'])->name('customer.store'); // Simpan customer baru
    Route::get('/{id}/edit', [CustomerController::class, 'edit'])->name('customer.edit'); // Form edit customer
    Route::put('/{id}', [CustomerController::class, 'update'])->name('customer.update'); // Update customer
    Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy'); // Hapus customer
});

// Rute untuk Penjualan
Route::prefix('sales')->group(function () {
    Route::get('/', [SalesController::class, 'index'])->name('sales.index');
    Route::get('/create', [SalesController::class, 'create'])->name('sales.create');
    Route::post('/', [SalesController::class, 'store'])->name('sales.store');
    Route::get('/invoice', [SalesController::class, 'generateInvoice'])->name('sales.invoice'); // Rute statis diletakkan di atas
    Route::get('/{id}', [SalesController::class, 'show'])->name('sales.show')->where('id', '[0-9]+');
});

