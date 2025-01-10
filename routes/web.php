<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SalesController;
use Laravel\Fortify\Fortify;

// Dashboard Route
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Fortify Register & Login Views
Fortify::registerView(fn() => view('auth.register'));
Fortify::loginView(fn() => view('auth.login'));

// Product Routes
Route::resource('product', ProductController::class)->except(['show']);

// Customer Routes
Route::resource('customer', CustomerController::class)->except(['show']);

// Sales Routes
Route::prefix('sales')->group(function () {
    Route::get('/', [SalesController::class, 'index'])->name('sales.index');
    Route::get('/create', [SalesController::class, 'create'])->name('sales.create');
    Route::post('/', [SalesController::class, 'store'])->name('sales.store');
    Route::get('/{id}', [SalesController::class, 'show'])->name('sales.show')->where('id', '[0-9]+');
    Route::delete('/{id}', [SalesController::class, 'destroy'])->name('sales.destroy');
    Route::get('/invoice/{id}', [SalesController::class, 'generateInvoice'])->name('sales.generateInvoice')->where('id', '[0-9]+');
    Route::get('/surat-jalan/{id}', [SalesController::class, 'generateSuratJalan'])->name('sales.generateSuratJalan')->where('id', '[0-9]+');
});
