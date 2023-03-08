<?php

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

// User
Route::prefix('user')->group(function () {
    Route::post('register', [\App\Http\Controllers\API\AuthController::class, 'register']);
    Route::middleware('auth:api')->group(function () {
        Route::get('me', [\App\Http\Controllers\API\AuthController::class, 'me']);
        Route::get('questions', [\App\Http\Controllers\API\QuestionController::class, 'index']);
        Route::get('form-data', [\App\Http\Controllers\API\FormController::class, 'getFormData']);
        Route::prefix('form')->group(function () {
            Route::post('confirm', [\App\Http\Controllers\API\FormController::class, 'confirm']);
            Route::post('submit', [\App\Http\Controllers\API\FormController::class, 'submit']);
        });
    });
});

// CMS
Route::prefix('cms')->group(function () {
    Route::post('login', [\App\Http\Controllers\API\CMS\AuthController::class, 'login']);
    Route::get('applications/download', [\App\Http\Controllers\API\CMS\ApplicationController::class, 'download'])->middleware(\App\Http\Middleware\CheckDownloadCSVToken::class);

    Route::middleware('auth:api-admin')->group(function () {
        Route::get('auth/me', [\App\Http\Controllers\API\CMS\AuthController::class, 'me']);
        Route::get('applications', [\App\Http\Controllers\API\CMS\ApplicationController::class, 'index']);
        Route::get('gifts', [\App\Http\Controllers\API\CMS\GiftController::class, 'index']);
        Route::middleware('role:' . \App\Enums\CMS\RoleEnum::ADMIN)->group(function () {
            Route::get('download/token',[\App\Http\Controllers\API\CMS\ApplicationController::class, 'createToken']);
            Route::apiResource('admins', \App\Http\Controllers\API\CMS\AdminController::class);
        });
    });
});

