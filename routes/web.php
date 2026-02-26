<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing.index');
});

use App\Http\Controllers\Auth\MerchantAuthController;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Merchant\DashboardController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Merchant\MenuController;

Route::prefix('merchant')->name('merchant.')->group(function () {
    // Guest routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [MerchantAuthController::class, 'showForm'])->name('login');
        Route::post('/login', [MerchantAuthController::class, 'login']);
        Route::post('/register', [MerchantAuthController::class, 'register'])->name('register');
    });

    // Protected routes
    Route::middleware(['auth', 'role:merchant'])->group(function () {
        Route::post('/logout', [MerchantAuthController::class, 'logout'])->name('logout');

        // Merchant profile
        Route::post('/profile', [DashboardController::class, 'storeProfile'])->name('profile.store');

        // Merchant dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Merchant Menus
        Route::post('/menus/{menu}/restore', [MenuController::class, 'restore'])->name('menus.restore');
        Route::resource('menus', MenuController::class);

        // Merchant Orders
        Route::get('/orders', [\App\Http\Controllers\Merchant\OrderController::class, 'index'])->name('orders.index');
        Route::patch('/orders/{order}/status', [\App\Http\Controllers\Merchant\OrderController::class, 'updateStatus'])->name('orders.update-status');
    });
});

Route::prefix('customer')->name('customer.')->group(function () {
    // Guest routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [CustomerAuthController::class, 'showForm'])->name('login');
        Route::post('/login', [CustomerAuthController::class, 'login']);
        Route::post('/register', [CustomerAuthController::class, 'register'])->name('register');
    });

    // Protected routes
    Route::middleware(['auth', 'role:customer'])->group(function () {
        Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');

        // Customer Profile
        Route::post('/profile', [CustomerDashboardController::class, 'storeProfile'])->name('profile.store');

        // Customer dashboard
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

        // Checkout
        Route::post('/checkout', [App\Http\Controllers\Customer\OrderController::class, 'store'])->name('checkout.store');

        // My Orders
        Route::get('/orders', [App\Http\Controllers\Customer\OrderHistoryController::class, 'index'])->name('orders.index');
    });
});

// Shared Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/invoices/{invoice}', [App\Http\Controllers\InvoiceController::class, 'show'])->name('invoices.show');
});
