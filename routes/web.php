<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\BuilderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;


Route::get('/', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::post('/cart/add', [CartController::class, 'add']);
Route::get('/cart', [CartController::class, 'index']);
Route::get('/builder', [BuilderController::class, 'index']);
Route::post('/builder/save', [BuilderController::class, 'save']);
Route::post('/builder/add-to-cart', [BuilderController::class, 'addToCart']);
Route::get('/checkout', [CheckoutController::class, 'index']);
Route::post('/checkout/process', [CheckoutController::class, 'process']);
Route::post('/builder/calc', [BuilderController::class, 'calc']);
Route::get('/login', function () {
    return view('auth.login');
});

Route::post('/login', [AuthController::class, 'login']);

// halaman register
Route::get('/register', function () {
    return view('auth.register');
});

// proses register
Route::post('/register', [AuthController::class, 'register']);