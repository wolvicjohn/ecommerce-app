<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('homepage');
Route::resource('products', ProductController::class);
Route::resource('carts', CartController::class);

Route::get('/dashboard', [ProductController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

Route::middleware('auth')->group(function () {
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
});

Route::post('/carts/remove-guest-item', [CartController::class, 'removeGuestItem'])->name('carts.removeGuestItem');

Route::resource('categories', CategoryController::class)->only(['create', 'store', 'destroy']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
