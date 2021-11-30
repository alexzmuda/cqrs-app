<?php

use App\Modules\Order\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

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

// recipes
Route::group(['middleware' => [], 'prefix' => 'v1'], function () {
    Route::match(['get'], '/orders', [OrderController::class, 'index']);
    Route::post('/order', [OrderController::class, 'create']);
    Route::get('/order/{id}', [OrderController::class, 'show']);
    // Route::put('/product', [OrderController::class, 'update']);
    Route::delete('/order/{id}', [OrderController::class, 'destroy']);
});
