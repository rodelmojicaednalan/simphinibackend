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

Route::group(['namespace' => 'Auth'], function() {
    Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
    Route::get('change-password/{token}', [App\Http\Controllers\Auth\LoginController::class, 'changepassword']);
    Route::post('change-password', [App\Http\Controllers\Auth\LoginController::class, 'storePassword']);
    Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function() {
    Route::resource('users', App\Http\Controllers\Client\UserController::class);
    Route::group(['prefix' => 'picklists'], function () {
        // Route::resource('countries', App\Http\Controllers\Picklists\CountryController::class);
        Route::group(['prefix' => 'countries'], function () {
            Route::get('/', [App\Http\Controllers\Picklists\CountryController::class, 'index']);
            Route::post('/', [App\Http\Controllers\Picklists\CountryController::class, 'store']);
            Route::get('/{hashedId}/edit', [App\Http\Controllers\Picklists\CountryController::class, 'edit']);
            Route::post('/{hashedId}', [App\Http\Controllers\Picklists\CountryController::class, 'update']);
            Route::delete('/{hashedId}', [App\Http\Controllers\Picklists\CountryController::class, 'delete']);
        });
        Route::group(['prefix' => 'treatments'], function () {
            Route::get('/', [App\Http\Controllers\Picklists\TreatmentController::class, 'index']);
            Route::post('/', [App\Http\Controllers\Picklists\TreatmentController::class, 'store']);
            Route::get('/{hashedId}/edit', [App\Http\Controllers\Picklists\TreatmentController::class, 'edit']);
            Route::post('/{hashedId}', [App\Http\Controllers\Picklists\TreatmentController::class, 'update']);
            Route::delete('/{hashedId}', [App\Http\Controllers\Picklists\TreatmentController::class, 'delete']);
        });
        
        // Route::get('', [App\Http\Controllers\Auth\RegisterController::class, 'register'])
    });

    Route::group(['prefix' => 'clients'], function () {
        Route::resource('/', App\Http\Controllers\Client\ClientController::class);
    });
});

Route::middleware('auth:admin')->get('/admin/superuser', function (Request $request) {
    return $request->user();
});

// Super Admin Routes (TO DO:: should add middleware for superadmin)
require __DIR__.'/admin.php';
