<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AddressController;

/* |-------------------------------------------------------------------------- | API Routes |-------------------------------------------------------------------------- | | Here is where you can register API routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | is assigned the "api" middleware group. Enjoy building your API! | */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::apiResource(name:'addresses',controller:UserController::class)
//    ->middleware(middleware:'auth:sanctum');

Route::get('/addresses', [AddressController::class, 'show'])->middleware(middleware:'auth:sanctum');
Route::post('/addresses', [AddressController::class, 'store'])->middleware(middleware:'auth:sanctum');
