<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AddressController;
use App\Http\Controllers\API\RestaurantAPIController;



/* |-------------------------------------------------------------------------- | API Routes |-------------------------------------------------------------------------- | | Here is where you can register API routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | is assigned the "api" middleware group. Enjoy building your API! | */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::apiResource(name:'addresses',controller:UserController::class)
//    ->middleware(middleware:'auth:sanctum');

// Route::get('/addresses', [AddressController::class, 'show'])->middleware(middleware:'auth:sanctum');
// Route::post('/addresses', [AddressController::class, 'store'])->middleware(middleware:'auth:sanctum');
Route::middleware('auth:sanctum')->controller(AddressController::class)->group(function () {
    Route::get('/addresses', 'show');
    Route::post('/addresses', 'store');
    Route::post('/addresses/{address_id}', 'setCurrentAddress');
});

Route::middleware('auth:sanctum')->patch('/user/{id}', [UserController::class , 'update']);

Route::middleware('auth:sanctum')->controller(RestaurantAPIController::class)->prefix('restaurants')->group(function () {
    Route::get('/', 'index');
    Route::get('/{restaurant_id}', 'show');
    Route::get('/{restaurant_id}/foods', 'foods');
});