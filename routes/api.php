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

    // Rutas para usuarios normales
    Route::middleware('role:user')->group(function () {
        Route::get('products', [ProductController::class, 'index']);
        Route::get('products/{id}', [ProductController::class, 'show']);
        Route::post('orders', [OrderController::class, 'store']);
        Route::get('orders', [OrderController::class, 'userOrders']);  // Ver órdenes del usuario autenticado
    });

    // Rutas para admin
    Route::middleware('role:admin')->group(function () {
        Route::resource('products', ProductController::class)->except(['show']);
        Route::resource('categories', CategoryController::class);
        Route::resource('orders', OrderController::class)->except(['store', 'userOrders']);
        Route::get('users', [UserController::class, 'index']);  // Admin puede ver usuarios
    });
});
