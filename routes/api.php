<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderdetailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas
Route::get('/test', function () {
    return json_encode(['name' => 'Hello World']);
});

// Rutas de usuarios
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);

Route::post('/user/new', [UserController::class, 'store']);

Route::middleware(['auth:sanctum', 'rol:admin,supervisor,cliente'])->group(function () {
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/logout', [UserController::class, 'logout']);
});

// Rutas de productos
Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);

Route::middleware(['auth:sanctum', 'rol:admin,supervisor,cliente'])->group(function () {
    Route::post('/product', [ProductController::class, 'store']);
    Route::put('/product/{id}', [ProductController::class, 'update']);
    Route::delete('/product/{id}', [ProductController::class, 'destroy']);
});


//Rutas orderdetails
Route::middleware(['auth:sanctum', 'rol:admin,supervisor,cliente'])->group(function () {
    Route::get('/orderdetails', [OrderdetailController::class, 'index']);
    // Route::get('orderdetails/me', [OrderdetailController::class, 'getOrdersByUser']);
    Route::post('/orderdetail', [OrderdetailController::class, 'store']);
    Route::get('/orderdetail/{id}', [OrderdetailController::class, 'show']);
    Route::put('/orderdetail/{id}', [OrderdetailController::class, 'update']);
    Route::delete('/orderdetail/{id}', [OrderdetailController::class, 'destroy']); // esta todavia no esta hecha 
});

// Rutas de ordenes
Route::middleware(['auth:sanctum', 'rol:admin,supervisor,cliente'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/order/new', [OrderController::class, 'store']);
    Route::get('/order/{id}', [OrderController::class, 'show']);
    Route::put('/order/{id}', [OrderController::class, 'update']);
    Route::delete('/order/{id}', [OrderController::class, 'destroy']);
    Route::get('/order/user/{id}', [OrderController::class, 'getOrdersByUser']);
});