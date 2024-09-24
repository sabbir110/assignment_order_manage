<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh-token', [AuthController::class, 'refresh']);

    Route::get('products', [ProductController::class, 'index']);
    Route::group(['middleware' => ['auth:api', "role:admin"]], function ($router) {
        Route::post('products', [ProductController::class, 'store']);
        Route::post('products/{id}', [ProductController::class, 'update']);
    });


    Route::group(['middleware' => ['auth:api', "role:user"]], function ($router) {
        Route::post('orders', [OrderController::class, 'store']);
        Route::get('orders/{id?}', [OrderController::class, 'index']);
    });
});
