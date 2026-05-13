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
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminProductController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// HOME
Route::get('/', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::get('/komponen', [ProductController::class, 'komponen']);


// BUILDER
Route::get('/builder', [BuilderController::class, 'index']);
Route::post('/builder/calc', [BuilderController::class, 'calc']);
Route::post('/builder/save', [BuilderController::class, 'save']);
Route::post('/builder/add-to-cart', [BuilderController::class, 'addToCart']);


// USER PAGE
Route::get('/user', [ProductController::class, 'user']);


// MAP
Route::get('/map', [MapController::class, 'index']);
Route::get('/api/markers', [MapController::class, 'getMarkers']);


/*
|--------------------------------------------------------------------------
| CART
|--------------------------------------------------------------------------
*/

Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/add', [CartController::class, 'add']);
Route::post('/cart/remove', [CartController::class, 'remove']);
Route::post('/cart/remove-selected', [CartController::class, 'removeSelected']);
Route::post('/cart/clear', [CartController::class, 'clear']);


/*
|--------------------------------------------------------------------------
| CHECKOUT
|--------------------------------------------------------------------------
*/

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/prepare', [CheckoutController::class, 'prepare']);
Route::post('/checkout/process', [CheckoutController::class, 'process']);

Route::get('/transaksi', [CheckoutController::class, 'index']);


/*
|--------------------------------------------------------------------------
| AUTH USER
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
| USER AREA
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | CHAT USER
    |--------------------------------------------------------------------------
    */

    // halaman chat
    Route::get('/chat', [ChatController::class, 'index']);

    // ambil semua pesan user login
    Route::get('/chat/messages', [ChatController::class, 'messages']);

    // kirim pesan user
    Route::post('/chat/send', [ChatController::class, 'send']);

    /*
    |--------------------------------------------------------------------------
    | LOGOUT USER
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});

 /*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | LOGIN ADMIN
    |--------------------------------------------------------------------------
    */

    Route::get('/login', [AdminController::class, 'loginPage'])
        ->name('admin.login');

    Route::post('/login', [AdminController::class, 'login']);

    Route::post('/logout', [AdminController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | ADMIN AREA
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth:admin')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard',
            [AdminController::class, 'dashboard']);

        /*
        |--------------------------------------------------------------------------
        | CHAT ADMIN
        |--------------------------------------------------------------------------
        */

        // halaman chat admin
        Route::get('/chat',
            [ChatController::class, 'adminIndex']);

        // ambil pesan user
        Route::get('/chat/messages/{userId}',
            [ChatController::class, 'adminMessages']);

        // balas pesan
        Route::post('/chat/reply/{userId}',
            [ChatController::class, 'reply']);

        /*
        |--------------------------------------------------------------------------
        | CRUD PRODUCT
        |--------------------------------------------------------------------------
        */

        Route::prefix('products')
            ->name('admin.products.')
            ->group(function () {

            // list produk
            Route::get('/',
                [AdminProductController::class, 'index'])
                ->name('index');

            // halaman tambah produk
            Route::get('/create',
                [AdminProductController::class, 'create'])
                ->name('create');

            // simpan produk
            Route::post('/store',
                [AdminProductController::class, 'store'])
                ->name('store');

            // halaman edit
            Route::get('/edit/{id}',
                [AdminProductController::class, 'edit'])
                ->name('edit');

            // update produk
            Route::post('/update/{id}',
                [AdminProductController::class, 'update'])
                ->name('update');

            // hapus produk
            Route::post('/delete/{id}',
                [AdminProductController::class, 'delete'])
                ->name('destroy');
        });
    });

    Route::get('/admin/products',
    [AdminProductController::class, 'index']);


    Route::prefix('orders')
    ->name('admin.orders.')
    ->group(function () {

    Route::get('/',
        [AdminOrderController::class, 'index'])
        ->name('index');

    Route::get('/{id}',
        [AdminOrderController::class, 'show'])
        ->name('show');

    Route::post('/status/{id}',
        [AdminOrderController::class, 'updateStatus'])
        ->name('status');
});
});

