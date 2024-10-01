<?php

use App\Livewire\Auth\ForgotPasswordPages;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ResettPasswordPages;
use App\Livewire\CancelPages;
use App\Livewire\CartPages;
use App\Livewire\CategoriesPages;
use App\Livewire\CheckoutPages;
use App\Livewire\HomePage;
use App\Livewire\MyOrderDetailPages;
use App\Livewire\MyOrdersPages;
use App\Livewire\ProductDetailPages;
use App\Livewire\ProductsPages;
use App\Livewire\SuccessPages;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', HomePage::class);
Route::get('/categories', CategoriesPages::class);
Route::get('/products', ProductsPages::class);
Route::get('/cart', CartPages::class);
Route::get('/products/{slug}', ProductDetailPages::class);


Route::middleware('guest')->group(function () {
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/register', RegisterPage::class);
    Route::get('/forgot', ForgotPasswordPages::class);
    Route::get('/reset', ResettPasswordPages::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', function () {
        auth()->guard('web')->logout();
        return redirect('/');
    });
    Route::get('/checkout', CheckoutPages::class);
    Route::get('/my-orders', MyOrdersPages::class);
    Route::get('/my-orders/{order_id}', MyOrderDetailPages::class)->name('my-order.show');
    Route::get('/success', SuccessPages::class)->name('success');
    Route::get('/cancel', CancelPages::class)->name('cancel');
});

// crendential login
// user: admintoko@gmail.com
// pass: admintoko1
