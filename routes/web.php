<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FoodPartyController;
use App\Http\Controllers\RestaurantController;

/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- | | Here is where you can register web routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | contains the "web" middleware group. Now create something great! | */

Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/category/{id}', 'showCategoryRestaurant')->name('category.show');
    Route::get('/restaurant/{id}', 'showRestaurantFood')->name('restaurant-food.show');
    Route::get('/payment/{id}', 'showPayment')->name('payment.show');
    Route::post('/payment/store', 'handlePayment')->name('payment.store');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'dashboard'
], )->group(function () {
    Route::get('/dashboard', function () {
            return view('dashboard');
        }
        )->name('dashboard');
        Route::get('/categories', function () {
            return view('dashboard.category');
        }
        )->name('category.edit');

        Route::resource('dashboard/foodType', CategoryController::class);
        Route::resource('dashboard/food', FoodController::class);
        Route::resource('dashboard/restaurant', RestaurantController::class);
        Route::get('dashboard/foodParty', [FoodPartyController::class , 'index'])->name('foodParty.index');
        Route::get('dashboard/{id}/orders', [RestaurantController::class , 'orders'])->name('restaurant.orders');
        Route::get('/{id}/carts', [PageController::class , 'carts'])->name('cart.show');
        Route::get('/dashboard/comments', [RestaurantController::class , 'comments'])->name('restaurant.comments');
    });
