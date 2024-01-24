<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

/* Route::get('/', function () {
    return view('welcome');
});
 */

Auth::routes();

Route::get('/', function () {
    return redirect('/admin/');
});


Route::prefix('admin')->middleware('auth')->group(
    function () {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

        Route::get('/settings', [App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');


        Route::post('/settings', [App\Http\Controllers\SettingController::class, 'store'])->name('settings.store');


        Route::resource('products', ProductController::class);
        Route::resource('customers', CustomerController::class);
        Route::resource('providers', ProviderController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('purchases', PurchaseController::class);


        Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
        Route::post('/cart', [App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
        Route::post('/cart/change-qty', [App\Http\Controllers\CartController::class, 'changeQty']);
        Route::delete('/cart/delete', [App\Http\Controllers\CartController::class, 'delete']);
        Route::delete('/cart/empty', [App\Http\Controllers\CartController::class, 'empty']);

        Route::get('/order', [App\Http\Controllers\OrderController::class, 'index'])->name('orders');

        Route::get('/purchaseCart', [App\Http\Controllers\PurchaseCartController::class, 'index'])->name('purchaseCart.index');
        Route::post('/purchaseCart', [App\Http\Controllers\PurchaseCartController::class, 'store'])->name('purchaseCart.store');
        Route::post('/purchaseCart/change-qty', [App\Http\Controllers\PurchaseCartController::class, 'changeQty']);
        Route::delete('/purchaseCart/delete', [App\Http\Controllers\PurchaseCartController::class, 'delete']);
        Route::delete('/purchaseCart/empty', [App\Http\Controllers\PurchaseCartController::class, 'empty']);

        Route::get('/purchase', [App\Http\Controllers\PurchaseController::class, 'index'])->name('purchase');
    }
);
