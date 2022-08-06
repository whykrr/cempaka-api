<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AuthClientController;
use App\Http\Controllers\API\ContentCategoryController;
use App\Http\Controllers\API\ContentController;

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

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth_client/login', [AuthClientController::class, 'login']);
Route::group([
    'middleware' => 'auth.jwt',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
});

Route::group([
    'middleware' => 'auth.jwt',
    'prefix' => 'auth_client'
], function ($router) {
    Route::post('logout', [AuthClientController::class, 'logout']);
    Route::post('refresh', [AuthClientController::class, 'refresh']);
    Route::get('me', [AuthClientController::class, 'me']);
});


Route::group([
    'middleware' => 'auth.jwt'
], function ($router) {
    Route::post('auth_client/register', [AuthClientController::class, 'register']);

    Route::group([
        'prefix' => 'content'
    ], function ($router) {
        Route::get('/', [ContentController::class, 'index']);
        Route::get('/{id}', [ContentController::class, 'show']);
        Route::post('/', [ContentController::class, 'store']);
        Route::put('/{id}', [ContentController::class, 'update']);
        Route::delete('/{id}', [ContentController::class, 'delete']);

        // categories
        Route::group([
            'prefix' => 'categories'
        ], function ($router) {
            Route::get('/', [ContentCategoryController::class, 'get']);
            Route::get('/{id}', [ContentCategoryController::class, 'detail']);
            Route::post('/', [ContentCategoryController::class, 'store']);
            Route::put('/{id}', [ContentCategoryController::class, 'update']);
            Route::delete('/{id}', [ContentCategoryController::class, 'delete']);
        });
    });
});
