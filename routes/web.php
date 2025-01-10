<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SalesController;
use Laravel\Fortify\Fortify;

// Route untuk Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Route untuk register & login
Fortify::registerView(fn() => view('auth.register'));
Fortify::loginView(fn() => view('auth.login'));

// Route untuk Barang Masuk dan Manajemen Produk
Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product.index');
    Route::get('/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/', [ProductController::class, 'store'])->name('product.store');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/{id}', [ProductController::class, 'update'])->name('product.update');
});

// Route untuk Manajemen Customer
Route::prefix('customer')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/{id}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
});

// Rute untuk Penjualan
Route::prefix('sales')->group(function () {
    Route::get('/', [SalesController::class, 'index'])->name('sales.index');
    Route::get('/create', [SalesController::class, 'create'])->name('sales.create');
    Route::post('/', [SalesController::class, 'store'])->name('sales.store');
    Route::get('/invoice/{id}', [SalesController::class, 'generateInvoice'])->name('sales.generateInvoice');
    Route::get('/surat-jalan/{id}', [SalesController::class, 'generateSuratJalan'])->name('sales.generatesurat_jalan');
    Route::get('/{id}', [SalesController::class, 'show'])->name('sales.show')->where('id', '[0-9]+');
    Route::delete('/sales/{id}', [SalesController::class, 'destroy'])->name('sales.destroy');
});
