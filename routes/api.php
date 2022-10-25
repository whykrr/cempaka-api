<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ContentController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\AuthClientController;
use App\Http\Controllers\API\ContentCategoryController;
use App\Http\Controllers\API\DisplayController;

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
// healtcheck
Route::get('/', function () {
    return response()->json(['message' => 'Welcome to API CMS']);
});

// OPEN API
Route::group(['prefix' => 'display'], function () {
    Route::get('/menubar', [DisplayController::class, 'menubar']);
    // route get content with slig
    Route::get('/content/{slug}', [DisplayController::class, 'content']);
    Route::get('/content/category/{slug_category}', [DisplayController::class, 'content_category']);
});

// Auth
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

// Auth Client
Route::group([
    'middleware' => 'auth.jwt',
    'prefix' => 'auth_client'
], function ($router) {
    Route::post('logout', [AuthClientController::class, 'logout']);
    Route::post('refresh', [AuthClientController::class, 'refresh']);
    Route::get('me', [AuthClientController::class, 'me']);
});

// All
Route::group([
    'middleware' => 'auth.jwt'
], function ($router) {
    Route::post('auth_client/register', [AuthClientController::class, 'register']);

    Route::group([
        'prefix' => 'users'
    ], function ($router) {
        Route::get('/', [AuthController::class, 'get']);
        Route::get('/{id}', [AuthController::class, 'detail'])->whereNumber('id');
        Route::put('/{id}', [AuthController::class, 'update'])->whereNumber('id');
        Route::delete('/{id}', [AuthController::class, 'delete'])->whereNumber('id');
    });

    Route::group([
        'prefix' => 'clients'
    ], function ($router) {
        Route::get('/', [AuthClientController::class, 'get']);
        Route::get('/{id}', [AuthClientController::class, 'detail'])->whereNumber('id');
        Route::put('/{id}', [AuthClientController::class, 'update'])->whereNumber('id');
        Route::delete('/{id}', [AuthClientController::class, 'delete'])->whereNumber('id');
    });


    // Content
    Route::group([
        'prefix' => 'contents'
    ], function ($router) {
        Route::get('/', [ContentController::class, 'get']);
        Route::get('/{id}', [ContentController::class, 'detail'])->whereNumber('id');
        Route::post('/', [ContentController::class, 'store']);
        Route::put('/{id}', [ContentController::class, 'update'])->whereNumber('id');
        Route::delete('/{id}', [ContentController::class, 'delete'])->whereNumber('id');
        Route::post('/upload/image', [ContentController::class, 'uploadImage']);

        // categories
        Route::group([
            'prefix' => 'categories'
        ], function ($router) {
            Route::get('/', [ContentCategoryController::class, 'get']);
            Route::get('/{id}', [ContentCategoryController::class, 'detail'])->whereNumber('id');
            Route::post('/', [ContentCategoryController::class, 'store']);
            Route::put('/{id}', [ContentCategoryController::class, 'update'])->whereNumber('id');
            Route::delete('/{id}', [ContentCategoryController::class, 'delete'])->whereNumber('id');
        });
    });

    // Projects
    Route::group([
        'prefix' => 'projects'
    ], function ($router) {
        Route::get('/', [ProjectController::class, 'get']);
        Route::get('/{id}', [ProjectController::class, 'detail'])->whereNumber('id');
        Route::post('/', [ProjectController::class, 'store']);
        Route::put('/{id}', [ProjectController::class, 'update'])->whereNumber('id');
        Route::delete('/{id}', [ProjectController::class, 'delete'])->whereNumber('id');
    });
});
