<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TransectionController;
use App\Http\Controllers\Api\BillController;

Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);

// Category Routes group with auth:api middleware
Route::middleware('auth:api')->group(function () {
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories/add', [CategoryController::class, 'store']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    Route::post('/categories/update/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/delete/{id}', [CategoryController::class, 'destroy']);
}); 

// Product Routes group with auth:api middleware
Route::middleware('auth:api')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products/add', [ProductController::class, 'store']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::post('/products/update/{id}', [ProductController::class, 'update']);
    Route::delete('/products/delete/{id}', [ProductController::class, 'destroy']);
});

// group routes for transaction
Route::middleware('auth:api')->group(function () {
    // Transaction routes can be added here
    Route::post('/pos/pay', [TransectionController::class, 'pay']);
    Route::get('/bill/print/{bill_id}', [BillController::class, 'printBill']); 
});


