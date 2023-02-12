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
Route::post('/user/new', [UserController::class, 'store']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::put('/user/{id}', [UserController::class, 'update']);
Route::delete('/user/{id}', [UserController::class, 'destroy']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/logout', [UserController::class, 'logout']);
});

// Rutas de productos
Route::get('/products', [ProductController::class, 'index']);
Route::post('/product', [ProductController::class, 'store']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::put('/product/{id}', [ProductController::class, 'update']);
Route::delete('/product/{id}', [ProductController::class, 'destroy']);
Route::get('/orders', [OrderController::class, 'index']);

//Rutas orderdetails
Route::get('/orderdetails', [OrderdetailController::class, 'index']);
Route::post('/orderdetail', [OrderdetailController::class, 'store']);
Route::get('/orderdetail/{id}', [OrderdetailController::class, 'show']);
Route::put('/orderdetail/{id}', [OrderdetailController::class, 'update']);
Route::delete('/orderdetail/{id}', [OrderdetailController::class, 'destroy']); // esta todavia no esta hecha 

// Rutas de ordenes
Route::post('/order/new', [OrderController::class, 'store']);
Route::get('/order/{id}', [OrderController::class, 'show']);
Route::put('/order/{id}', [OrderController::class, 'update']);
Route::delete('/order/{id}', [OrderController::class, 'destroy']);
Route::get('/order/user/{id}', [OrderController::class, 'getOrdersByUser']);