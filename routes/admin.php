<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'admin'], function () {

  Route::group(['namespace' => 'Auth'], function() {
    Route::get('change-password/{token}', [App\Http\Controllers\Admin\Auth\LoginController::class, 'changepassword']);
    Route::post('change-password', [App\Http\Controllers\Admin\Auth\LoginController::class, 'storePassword']);
    Route::post('login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'login']);
    Route::post('logout', [App\Http\Controllers\Admin\Auth\LoginController::class, 'logout']);
  });

  Route::group(['middleware' => 'auth:admin'], function() {
    Route::resource('user', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('client', \App\Http\Controllers\Admin\ClientController::class);
    Route::resource('dashboard', \App\Http\Controllers\Admin\DashboardController::class);

    Route::prefix('user')->group(function(){
      Route::get('index',[App\Http\Controllers\Admin\UserController::class,'index']);
      Route::post('store',[App\Http\Controllers\Admin\UserController::class,'store']);
      Route::patch('{id}/update',[App\Http\Controllers\Admin\UserController::class,'update']);
      Route::delete('{id}/delete',[App\Http\Controllers\Admin\UserController::class,'delete']);
    });

    Route::prefix('client')->group(function(){
      Route::get('index', [App\Http\Controllers\Admin\ClientController::class, 'index']);
    });

    Route::prefix('profile')->group(function(){
      Route::patch('update', [App\Http\Controllers\Admin\ProfileController::class,'update']);
    });

    Route::prefix('role')->group(function(){
      Route::get('/', [App\Http\Controllers\Admin\RoleController::class,'index']);
      Route::post('store', [App\Http\Controllers\Admin\RoleController::class,'store']);
    });
  });

});