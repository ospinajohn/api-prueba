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

// Rutas de usuarios
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/me', [UserController::class, 'getUserProfile']);
    Route::put('/me/updateProfile', [UserController::class, 'updateProfile']);
    Route::post('/password/forgot', [UserController::class, 'forgot']);
    Route::put('/password/reset', [UserController::class, 'reset']);
    Route::put('/me/updatePassword', [UserController::class, 'updatePassword']);
});



Route::middleware(['auth:sanctum', 'rol:admin,supervisor,cliente'])->group(function () {
    Route::post('/user/new', [UserController::class, 'store']);
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/logout', [UserController::class, 'logout']);
});

// admin
Route::middleware(['auth:sanctum', 'rol:admin'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'indexAdmin']);
});

// Rutas de productos
Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);

// Rutas de productos para admin y supervisor
Route::middleware(['auth:sanctum', 'rol:admin,supervisor'])->group(function () {
    Route::get('/admin/products', [ProductController::class, 'adminProducts']);
    Route::post('/product/new', [ProductController::class, 'store']);
    Route::put('/product/{id}', [ProductController::class, 'update']);
    Route::delete('/product/{id}', [ProductController::class, 'destroy']);
});


//Rutas orderdetails
Route::middleware(['auth:sanctum', 'rol:admin,supervisor,cliente'])->group(function () {
    Route::get('/orderdetails', [OrderdetailController::class, 'index']);
    Route::post('/orderdetail', [OrderdetailController::class, 'store']);
    Route::get('/orderdetail/{id}', [OrderdetailController::class, 'show']);
    Route::put('/orderdetail/{id}', [OrderdetailController::class, 'update']);
    Route::delete('/orderdetail/{id}', [OrderdetailController::class, 'destroy']); // esta todavia no esta hecha 
});

// Rutas de ordenes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/order/{id}', [OrderController::class, 'show']);
    Route::get('orders/me', [OrderController::class, 'getOrdersByUser']);
    Route::post('/order/new', [OrderController::class, 'store']);
});

// Rutas de ordenes para admin y supervisor
Route::middleware(['auth:sanctum', 'rol:admin,supervisor'])->group(function () {
    Route::get('/admin/orders', [OrderController::class, 'index']);
    Route::put('/admin/order/{id}', [OrderController::class, 'update']);
    Route::delete('/admin/order/{id}', [OrderController::class, 'destroy']);
});