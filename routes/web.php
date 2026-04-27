<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\BuilderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTE (BISA DIAKSES SEMUA)
|--------------------------------------------------------------------------
*/

// HOME & PRODUCT
Route::get('/', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::get('/komponen', [ProductController::class, 'komponen']);

// BUILDER (VIEW)
Route::get('/builder', [BuilderController::class, 'index']);
Route::post('/builder/calc', [BuilderController::class, 'calc']);

// USER PAGE
Route::get('/user', [ProductController::class, 'user']);

// CHAT (AMBIL DATA)
Route::get('/chat/get', [ChatController::class, 'get']);


/*
|--------------------------------------------------------------------------
| AUTH ROUTE (HANYA UNTUK GUEST)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', function () {
        return view('auth.register');
    });

    Route::post('/register', [AuthController::class, 'register']);
});


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTE (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // CHAT (KIRIM PESAN)
    Route::post('/chat/send', [ChatController::class, 'send']);
    Route::get('/chat/me', [ChatController::class, 'getChat']);

    // admin
    Route::get('/admin/chat/{userId}', [ChatController::class, 'adminGetChat']);
    Route::post('/admin/chat/reply/{userId}', [ChatController::class, 'reply']);

    // CART
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/remove', [CartController::class, 'remove']);
    Route::post('/cart/clear', [CartController::class, 'clear']);

    // BUILDER ACTION
    Route::post('/builder/save', [BuilderController::class, 'save']);
    Route::post('/builder/add-to-cart', [BuilderController::class, 'addToCart']);

    // CHECKOUT
    Route::get('/transaksi', [CheckoutController::class, 'index']);
    Route::post('/checkout/process', [CheckoutController::class, 'process']);

    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout']);
});