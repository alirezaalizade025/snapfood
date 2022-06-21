<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\FoodTypeController;
use App\Http\Controllers\RestaurantController;

/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- | | Here is where you can register web routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | contains the "web" middleware group. Now create something great! | */

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
            return view('dashboard');
        }
        )->name('dashboard');
        Route::get('/categories', function () {
            return view('dashboard.category');
        }
        )->name('category.edit');

        Route::resource('/foodType', FoodTypeController::class);
        Route::resource('/food', FoodController::class);
        Route::resource('/restaurant', RestaurantController::class);
    });
