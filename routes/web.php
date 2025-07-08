<?php

// use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

Route::get('/', [ProductController::class, 'index'])->name('homepage');

Route::resource('products', ProductController::class);
Route::resource('carts', CartController::class);

