<?php

use App\Http\Controllers\Admin\DashboardController as AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Merchant\DashboardController as MerchantController;
use App\Http\Controllers\MerchantApplicationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Redirect root to products
Route::get('/', fn() => redirect()->route('products.index'));

// ── Auth ──────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Public product listing ────────────────────────────────────────────────
Route::get('/products',          [ProductController::class, 'index'])->name('products.index');

// ── User biasa (beli, chat, favorit) — super_admin diblokir ──────────────
Route::middleware(['auth', 'not_admin'])->group(function () {

    // Produk milik sendiri (user & merchant sama-sama bisa jual)
    // PENTING: /products/create harus didaftarkan SEBELUM /products/{product}
    // agar Laravel tidak menganggap "create" sebagai wildcard {product}
    Route::get('/products/create',          [ProductController::class, 'create'])->name('products.create');
    Route::post('/products',                [ProductController::class, 'store'])->name('products.store');
    Route::get('/my-products',              [ProductController::class, 'myProducts'])->name('products.my');
    Route::get('/products/{product}/edit',  [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}',       [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}',    [ProductController::class, 'destroy'])->name('products.destroy');

    // Transaksi (hanya user biasa yang bisa beli)
    Route::get('/products/{product}/checkout',   [TransactionController::class, 'checkout'])->name('products.checkout');
    Route::post('/products/{product}/purchase',  [TransactionController::class, 'purchase'])->name('products.purchase');
    Route::get('/transactions',                  [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}',    [TransactionController::class, 'show'])->name('transactions.show');
    Route::patch('/transactions/{transaction}/confirm',  [TransactionController::class, 'confirm'])->name('transactions.confirm');
    Route::patch('/transactions/{transaction}/reject',   [TransactionController::class, 'reject'])->name('transactions.reject');
    Route::patch('/transactions/{transaction}/complete', [TransactionController::class, 'complete'])->name('transactions.complete');
    Route::patch('/transactions/{transaction}/cancel',   [TransactionController::class, 'cancel'])->name('transactions.cancel');
    Route::patch('/transactions/{transaction}/receive',  [TransactionController::class, 'receive'])->name('transactions.receive');

    // Chat
    Route::get('/chats',                        [ChatController::class, 'index'])->name('chats.index');
    Route::get('/chats/{chat}',                 [ChatController::class, 'show'])->name('chats.show');
    Route::post('/products/{product}/chat',     [ChatController::class, 'startChat'])->name('chats.start');
    Route::post('/chats/{chat}/messages',       [ChatController::class, 'sendMessage'])->name('chats.send');

    // Favorit
    Route::get('/favorites',                    [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/products/{product}/favorite', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});

// Detail produk (public) — didaftarkan SETELAH /products/create agar tidak konflik
Route::get('/products/{product}',[ProductController::class, 'show'])->name('products.show');

// ── Profile & Notifikasi (semua role boleh) ───────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile',       [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',       [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/notifications',                   [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-chats',      [NotificationController::class, 'unreadChats'])->name('notifications.unread-chats');
    Route::get('/notifications/unread-transactions',[NotificationController::class, 'unreadTransactions'])->name('notifications.unread-transactions');
    Route::post('/notifications/{id}/read',        [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all',         [NotificationController::class, 'markAllRead'])->name('notifications.read-all');

    // Pendaftaran Merchant (hanya user biasa, bukan merchant/admin)
    Route::get('/merchant/apply',          [MerchantApplicationController::class, 'create'])->name('merchant.apply.create');
    Route::post('/merchant/apply',         [MerchantApplicationController::class, 'store'])->name('merchant.apply.store');
    Route::get('/merchant/apply/status',   [MerchantApplicationController::class, 'status'])->name('merchant.apply.status');
});

// ── Merchant dashboard ───────────────────────────────────────────────────
Route::middleware(['auth', 'merchant'])->prefix('merchant')->name('merchant.')->group(function () {
    Route::get('/',                                     [MerchantController::class, 'index'])->name('dashboard');

    Route::get('/products',                             [MerchantController::class, 'products'])->name('products');
    Route::get('/products/create',                      [MerchantController::class, 'createProduct'])->name('products.create');
    Route::post('/products',                            [MerchantController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{product}/edit',              [MerchantController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{product}',                   [MerchantController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}',                [MerchantController::class, 'destroyProduct'])->name('products.destroy');

    Route::get('/stock',                                [MerchantController::class, 'stock'])->name('stock');
    Route::patch('/stock/{product}',                    [MerchantController::class, 'updateStock'])->name('stock.update');

    Route::get('/sales',                                [MerchantController::class, 'sales'])->name('sales');
});

// ── Super Admin ───────────────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/',                             [AdminController::class, 'index'])->name('dashboard');

    Route::get('/products',                     [AdminController::class, 'products'])->name('products');
    Route::delete('/products/{product}',        [AdminController::class, 'deleteProduct'])->name('products.delete');

    Route::get('/users',                        [AdminController::class, 'users'])->name('users');
    Route::delete('/users/{user}',              [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::patch('/users/{user}/promote',       [AdminController::class, 'promoteToMerchant'])->name('users.promote');
    Route::patch('/users/{user}/demote',        [AdminController::class, 'demoteToUser'])->name('users.demote');

    Route::get('/categories',                   [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories',                  [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{category}',        [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}',     [AdminController::class, 'deleteCategory'])->name('categories.delete');

    // Banner
    Route::get('/banners',              [AdminController::class, 'banners'])->name('banners');
    Route::post('/banners',             [AdminController::class, 'storeBanner'])->name('banners.store');
    Route::delete('/banners',           [AdminController::class, 'deleteBanner'])->name('banners.delete');

    // Pendaftaran Merchant
    Route::get('/merchant-applications',                          [MerchantApplicationController::class, 'adminIndex'])->name('merchant-applications.index');
    Route::get('/merchant-applications/{application}',            [MerchantApplicationController::class, 'adminShow'])->name('merchant-applications.show');
    Route::patch('/merchant-applications/{application}/approve',  [MerchantApplicationController::class, 'approve'])->name('merchant-applications.approve');
    Route::patch('/merchant-applications/{application}/reject',   [MerchantApplicationController::class, 'reject'])->name('merchant-applications.reject');
});
