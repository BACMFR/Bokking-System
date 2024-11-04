<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BusinessController;
use App\Http\Controllers\Business\ServiceController;

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

// Auth routes 
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api');

Route::middleware(['auth:api', 'admin'])->group(function () {
    // Business routes
    Route::get('/business', [BusinessController::class, 'index']);
    Route::post('/business', [BusinessController::class, 'store']);
    Route::put('/business/{id}', [BusinessController::class, 'update']);
    Route::delete('/business/{id}', [BusinessController::class, 'destroy']);

    // User routes
    Route::get('/user', [UserController::class, 'index']);
    Route::post('/user', [UserController::class, 'store']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);
});

Route::middleware('auth:api')->group(function () {
    // Service routes
    Route::get('/service', [ServiceController::class, 'index']);
    Route::post('/service', [ServiceController::class, 'store']);
    Route::put('/service/{id}', [ServiceController::class, 'update']);
    Route::delete('/service/{id}', [ServiceController::class, 'destroy']);

    // Booking routes
    Route::get('/booking', [BookingsController::class, 'index']);
    Route::post('/booking', [BookingsController::class, 'store']);
    Route::put('/booking/{id}', [BookingsController::class, 'update']);
    Route::delete('/booking/{id}', [BookingsController::class, 'destroy']);
    
    // Review routes
    Route::get('/review', [ReviewsController::class, 'index']);
    Route::get('/review/business/{id}', [ReviewsController::class, 'business_review']);
    Route::post('/review', [ReviewsController::class, 'store']);
    Route::put('/review/{id}', [ReviewsController::class, 'update']);
    Route::delete('/review/{id}', [ReviewsController::class, 'destroy']);
});
