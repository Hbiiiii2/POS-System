<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;

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

Route::redirect('/', 'login');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // Route for the getting the data feed
    Route::get('/json-data-feed', [DataFeedController::class, 'getDataFeed'])->name('json_data_feed');

    // Dashboard - accessible by all authenticated users
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // POS System Routes
    Route::resource('categories', CategoryController::class)->middleware(['role:admin']);
    Route::resource('products', ProductController::class)->middleware(['role:admin']);

    Route::prefix('pos')->middleware(['role:kasir'])->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('pos.index');
        // Route::get('/test', [TransactionController::class, 'test'])->name('pos.test');
        Route::post('/cart/add', [TransactionController::class, 'addToCart'])->name('pos.cart.add');
        Route::post('/cart/remove', [TransactionController::class, 'removeFromCart'])->name('pos.cart.remove');
        Route::post('/checkout', [TransactionController::class, 'checkout'])->name('pos.checkout');
        Route::get('/success/{id}', [TransactionController::class, 'success'])->name('pos.success');
        Route::get('/receipt/{id}', [TransactionController::class, 'receipt'])->name('pos.receipt');
    });

    // Test POS Routes (for testing purposes) - Admin only
    Route::prefix('test')->middleware(['role:admin'])->group(function () {
        Route::get('/pos', [TransactionController::class, 'test'])->name('test.pos');
        Route::post('/cart/add', [TransactionController::class, 'addToCart'])->name('test.cart.add');
        Route::post('/cart/remove', [TransactionController::class, 'removeFromCart'])->name('test.cart.remove');
    });

    // Reports Routes
    Route::prefix('reports')->middleware(['role:owner'])->group(function () {
        Route::get('/daily', [ReportController::class, 'daily'])->name('reports.daily');
        Route::get('/weekly', [ReportController::class, 'weekly'])->name('reports.weekly');
        Route::get('/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
        Route::get('/export', [ReportController::class, 'export'])->name('reports.export');
    });

});
