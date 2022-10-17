<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\FieldPriceController;
use App\Http\Controllers\InventoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/items', [ItemController::class, 'index']);
Route::get('/fields-price', [FieldPriceController::class, 'index']);
Route::get('/item/{item}', [ItemController::class, 'show']);
Route::get('/time', function(){
    $time = new DateTime();
    return response(['time'=> $time]);
});

//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::resource('fields', FieldController::class);
    Route::post('/gain-all', [FieldController::class, 'gainAll']);
    Route::post('/wallet', [WalletController::class,'show']);
    Route::resource('inventories', InventoryController::class);
});
