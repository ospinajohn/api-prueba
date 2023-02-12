<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderdetailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas
Route::get('/test', function () {
    return json_encode(['name' => 'Hello World']);
});

// Rutas de usuarios
Route::get('/users', [UserController::class, 'index']);
Route::post('/user/register', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::put('/user/{id}', [UserController::class, 'update']);
Route::delete('/user/{id}', [UserController::class, 'destroy']);

// Rutas de productos
Route::get('/products', [ProductController::class, 'index']);
Route::post('/product', [ProductController::class, 'store']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::put('/product/{id}', [ProductController::class, 'update']);
Route::delete('/product/{id}', [ProductController::class, 'destroy']);

//Rutas orderdetails
Route::get('/orderdetails', [OrderdetailController::class, 'index']);
Route::post('/orderdetail', [OrderdetailController::class, 'store']);
Route::get('/orderdetail/{id}', [OrderdetailController::class, 'show']);
Route::put('/orderdetail/{id}', [OrderdetailController::class, 'update']);
Route::delete('/orderdetail/{id}', [OrderdetailController::class, 'destroy']); // esta todavia no esta hecha 

// Rutas de ordenes
Route::get('/orders', [OrderController::class, 'index']);
Route::post('/order', [OrderController::class, 'store']);
Route::get('/order/{id}', [OrderController::class, 'show']);
Route::put('/order/{id}', [OrderController::class, 'update']);
Route::delete('/order/{id}', [OrderController::class, 'destroy']);
Route::get('/order/user/{id}', [OrderController::class, 'getOrdersByUser']);
