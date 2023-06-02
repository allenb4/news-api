<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\{ArticleController,CategoryController,UserPreferenceController};


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');

    Route::get('/user', 'user')->middleware('auth:api');
});

Route::middleware('auth:api')->group(function () {
    Route::resource('articles', ArticleController::class)->only('index');

    Route::controller(UserPreferenceController::class)->group(function () {
        Route::get('/user-preferences', 'index');
        Route::post('/user-preferences', 'store');
    });

    Route::resource('categories', CategoryController::class)
        ->only('index');
});
