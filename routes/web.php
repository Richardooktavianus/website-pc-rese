<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\BuilderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProductController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTE (BISA DIAKSES SEMUA)
|--------------------------------------------------------------------------
*/

// HOME & PRODUCT
Route::get('/', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::get('/komponen', [ProductController::class, 'komponen']);
// PUBLIC ROUTE
  Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::post('/cart/remove', [CartController::class, 'remove']);
    Route::post('/cart/remove-selected', [CartController::class, 'removeSelected']); // ← hapus terpilih
    Route::post('/cart/clear', [CartController::class, 'clear']);
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/builder/save', [BuilderController::class, 'save']);
    Route::post('/builder/add-to-cart', [BuilderController::class, 'addToCart']);
Route::post('/checkout/prepare', [CheckoutController::class, 'prepare']); // simpan item terpilih ke session
    Route::get('/transaksi', [CheckoutController::class, 'index']);            // halaman checkout
    Route::post('/checkout/process', [CheckoutController::class, 'process']); // proses bayar & hapus dari cart
 
// BUILDER (VIEW)
Route::get('/builder', [BuilderController::class, 'index']);
Route::post('/builder/calc', [BuilderController::class, 'calc']);

// USER PAGE
Route::get('/user', [ProductController::class, 'user']);

// CHAT (AMBIL DATA)
Route::get('/chat/get', [ChatController::class, 'get']);

Route::get('/map', [MapController::class, 'index']);
Route::get('/api/markers', [MapController::class, 'getMarkers']);

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

    // CHAT User (KIRIM PESAN)
    Route::get('/chat', [ChatController::class, 'index']);
    Route::post('/chat/send', [ChatController::class, 'send']);
    Route::get('/chat/messages', [ChatController::class, 'messages']);
    Route::get('/chat/get', [ChatController::class, 'get']);

    // ADMIN CHAT
    Route::get('/admin/chat/{userId}', [ChatController::class, 'adminGetChat']);
    Route::post('/admin/chat/reply/{userId}', [ChatController::class, 'reply']);

    // CART ← tambah route /cart/add di sini
    // Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    // Route::get('/cart', [CartController::class, 'index']);
    //            // ← INI YANG DITAMBAHKAN
    // Route::post('/cart/remove', [CartController::class, 'remove']);
    // Route::post('/cart/clear', [CartController::class, 'clear']);

    // BUILDER ACTION
    // Route::post('/builder/save', [BuilderController::class, 'save']);
    // Route::post('/builder/add-to-cart', [BuilderController::class, 'addToCart']);

    // CHECKOUT
    // Route::get('/transaksi', [CheckoutController::class, 'index']);
    // Route::post('/checkout/process', [CheckoutController::class, 'process']);

    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('admin')
    ->prefix('admin')
    ->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::get('/chat', [ChatController::class, 'adminIndex']);
    Route::get('/chat/messages/{userId}', [ChatController::class, 'adminMessages']);
    Route::post('/chat/reply/{userId}', [ChatController::class, 'reply']);
});


// ADMIN LOGIN
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'loginForm']);
    Route::post('/login', [AdminController::class, 'login']);
});


// PRODUCT CRUD ADMIN
Route::get('/products', [AdminProductController::class, 'index']);
Route::get('/products/create', [AdminProductController::class, 'create']);
Route::post('/products/store', [AdminProductController::class, 'store']);
Route::get('/products/edit/{id}', [AdminProductController::class, 'edit']);
Route::post('/products/update/{id}', [AdminProductController::class, 'update']);
Route::post('/products/delete/{id}', [AdminProductController::class, 'delete']);