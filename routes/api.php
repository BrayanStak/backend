<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;

Route::options('{any}', function () {
    return response()->json([]);
})->where('any', '.*');


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'index']);
    
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('roles', RoleController::class);
});
