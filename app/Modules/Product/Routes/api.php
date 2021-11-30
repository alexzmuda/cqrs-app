<?php

use App\Modules\Product\Http\Controllers\ProductController;
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
    Route::match(['get'], '/products', [ProductController::class, 'index']);
    Route::post('/product', [ProductController::class, 'create']);
    Route::get('/product/{id}', [ProductController::class, 'show']);
    Route::put('/product', [ProductController::class, 'update']);
    Route::delete('/product/{id}', [ProductController::class, 'destroy']);
});
