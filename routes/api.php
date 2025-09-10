<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api', 'prefix' => 'v1'], function () {
    Route::group([ 'prefix' => 'auth' ], function () {
        Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
        Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:api');
        Route::post('refresh', [App\Http\Controllers\AuthController::class, 'refresh'])->middleware('auth:api');
        Route::post('me', [App\Http\Controllers\AuthController::class, 'me'])->middleware('auth:api');
    });

    Route::resource('/usuarios', \App\Http\Controllers\UserController::class)->except('create', 'edit');
    Route::resource('/entidad', \App\Http\Controllers\EntidadController::class)->except('create', 'edit');
    Route::resource('/departamentos', \App\Http\Controllers\DepartmentController::class)->only('index');
    Route::resource('/distritos', \App\Http\Controllers\DistritoController::class)->only('index');
    Route::resource('/provincias', \App\Http\Controllers\ProvinciaController::class)->only('index');
});
//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
