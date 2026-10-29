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

    // Dashboard untuk semua pengguna yang login.
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Profil pribadi pengguna.
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')->group(function () {

        // Pengelolaan kategori.
        Route::resource('categories', CategoryController::class)
            ->only(['create', 'store', 'edit', 'update', 'destroy']);

        // Pengelolaan produk.
        Route::resource('products', ProductController::class)
            ->only(['create', 'store', 'edit', 'update', 'destroy']);

        // Pengelolaan supplier.
        Route::resource('suppliers', SupplierController::class)
            ->only(['create', 'store', 'edit', 'update', 'destroy']);

        // Pembatalan pembelian khusus admin.
        Route::post(
            '/purchases/{purchase}/cancel',
            [PurchaseController::class, 'cancel']
        )->name('purchases.cancel');

        // Pembatalan penjualan khusus admin.
        Route::post(
            '/sales/{sale}/cancel',
            [SaleController::class, 'cancel']
        )->name('sales.cancel');

        // Laporan khusus admin.
        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');

        // Manajemen akun khusus admin.
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


    /*
    |--------------------------------------------------------------------------
    | ADMIN DAN STAFF
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin,staff')->group(function () {

        // Daftar dan detail kategori.
        Route::resource('categories', CategoryController::class)
            ->only(['index', 'show']);

        // Daftar dan detail produk.
        Route::resource('products', ProductController::class)
            ->only(['index', 'show']);

        // Daftar dan detail supplier.
        Route::resource('suppliers', SupplierController::class)
            ->only(['index', 'show']);

        // Transaksi pembelian.
        Route::resource('purchases', PurchaseController::class)
            ->only(['index', 'create', 'store', 'show']);

        // Transaksi penjualan.
        Route::resource('sales', SaleController::class)
            ->only(['index', 'create', 'store', 'show']);
    });

});

require __DIR__.'/auth.php';