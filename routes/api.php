<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AddressController;
use App\Http\Controllers\API\CommentController;
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
    Route::get('/addresses', 'index');
    Route::post('/addresses', 'store');
    Route::post('/addresses/{address_id}', 'setCurrentAddress');
});

Route::middleware('auth:sanctum')->patch('/user/{id}', [UserController::class , 'update']);

Route::middleware('auth:sanctum')->controller(RestaurantAPIController::class)->prefix('restaurants')->group(function () {
    Route::get('/', 'index');
    Route::get('/{restaurant_id}', 'show');
    Route::get('/{restaurant_id}/foods', 'foods');
});

Route::middleware('auth:sanctum')->controller(CartController::class)->prefix('carts')->group(function () {
    Route::get('/', 'index');
    Route::get('/{cart_id}', 'show');
    Route::post('/add', 'store');
    Route::patch('/add', 'update');
    Route::post('/{cart_id}/pay', 'sendToPay');
});

Route::middleware('auth:sanctum')->controller(CommentController::class)->prefix('comments')->group(function () {
    Route::get('/', 'show');
    Route::post('/', 'store');
});

Route::controller(AuthController::class)->prefix('users')->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});
Route::post('/users/logout', [AuthController::class , 'logout'])->middleware('auth:sanctum');
