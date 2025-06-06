<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ReportController;
use Laravel\Fortify\Fortify;
use App\Http\Controllers\CustomAuthenticatedSessionController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\FaceRecognitionController;


Route::post('/register-face', [FaceRecognitionController::class, 'registerWithFace'])->name('register.face');
Route::post('/login-face', [FaceRecognitionController::class, 'loginWithFace'])->name('login.face');

// Fortify Register & Login Views
Fortify::registerView(fn() => view('auth.register'));
Fortify::loginView(fn() => view('auth.login'));

Route::post('/logout', [CustomAuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::post('/chatbot-api', [ChatbotController::class, 'handle'])->name('chatbot.api');

Route::get('/report/excel', [ReportController::class, 'exportExcel'])->name('report.excel');
Route::get('/report/pdf', [ReportController::class, 'exportPDF'])->name('report.pdf');


// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Product Routes
Route::resource('product', ProductController::class)
    ->middleware(['auth'])
    ->except(['show']);

// Customer Routes
Route::resource('customer', CustomerController::class)
    ->middleware(['auth'])
    ->except(['show']);

// Sales Routes
Route::prefix('sales')->middleware(['auth'])->group(function () {
    Route::get('/', [SalesController::class, 'index'])->name('sales.index');
    Route::get('/create', [SalesController::class, 'create'])->name('sales.create');
    Route::post('/', [SalesController::class, 'store'])->name('sales.store');
    Route::get('/{id}', [SalesController::class, 'show'])->name('sales.show')->where('id', '[0-9]+');
    Route::delete('/{id}', [SalesController::class, 'destroy'])->name('sales.destroy');
    Route::get('/invoice/{id}', [SalesController::class, 'generateInvoice'])->name('sales.generateInvoice')->where('id', '[0-9]+');
    Route::get('/surat-jalan/{id}', [SalesController::class, 'generateSuratJalan'])->name('sales.generateSuratJalan')->where('id', '[0-9]+');
});
