<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {

    // Dashboard: semua pengguna yang sudah login.
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Profil milik pengguna yang sedang login.
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    // ADMIN DAN STAFF: hanya melihat kategori, produk, supplier.
    Route::middleware('role:admin,staff')->group(function () {

        Route::resource('categories', CategoryController::class)
            ->only(['index', 'show']);

        Route::resource('products', ProductController::class)
            ->only(['index', 'show']);

        Route::resource('suppliers', SupplierController::class)
            ->only(['index', 'show']);


        // ADMIN DAN STAFF: transaksi pembelian dan penjualan.
        Route::resource('purchases', PurchaseController::class)
            ->only(['index', 'create', 'store', 'show']);

        Route::resource('sales', SaleController::class)
            ->only(['index', 'create', 'store', 'show']);
    });


    // ADMIN SAJA: mengelola kategori, produk, dan supplier.
    Route::middleware('role:admin')->group(function () {

        Route::resource('categories', CategoryController::class)
            ->only(['create', 'store', 'edit', 'update', 'destroy']);

        Route::resource('products', ProductController::class)
            ->only(['create', 'store', 'edit', 'update', 'destroy']);

        Route::resource('suppliers', SupplierController::class)
            ->only(['create', 'store', 'edit', 'update', 'destroy']);


        // Pembatalan transaksi hanya untuk admin.
        Route::post(
            '/purchases/{purchase}/cancel',
            [PurchaseController::class, 'cancel']
        )->name('purchases.cancel');

        Route::post(
            '/sales/{sale}/cancel',
            [SaleController::class, 'cancel']
        )->name('sales.cancel');


        // Laporan hanya untuk admin.
        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');


        // Manajemen akun hanya untuk admin.
        Route::resource('users', UserController::class)
            ->only([
                'index',
                'create',
                'store',
                'edit',
                'update',
                'destroy'
            ]);
    });
});

require __DIR__.'/auth.php';