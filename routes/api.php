<?php

use App\Http\Controllers\API\AdminAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\HomeController;

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


// user
Route::post('user/register', [AuthController::class, 'register']);
Route::post('user/login', [AuthController::class, 'login']);

Route::middleware('auth:users')->group(function () {
    Route::post('user/logout', [AuthController::class, 'logout']);

    Route::get('user/me', [AuthController::class, 'me']);
});







// admin
Route::post('admin/register', [AdminAuthController::class, 'register']);
Route::post('admin/login', [AdminAuthController::class, 'login']);

Route::middleware('auth:admins')->group(function () {
    // Route::get('admin/me', request()->user()->name);
    Route::post('admin/logout', [AdminAuthController::class, 'logout']);

    Route::get('admin/me', [AdminAuthController::class, 'me']);
});
