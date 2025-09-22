<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api', 'prefix' => 'v1'], function () {
    Route::group(['prefix' => 'auth' ], function () {
        Route::post('login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
        Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:api');
        Route::post('refresh', [App\Http\Controllers\AuthController::class, 'refresh'])->middleware('auth:api');
        Route::post('me', [App\Http\Controllers\AuthController::class, 'me'])->middleware('auth:api');
    });

    Route::group(['middleware' => 'auth:api'], function () {
        Route::resource('/usuarios', \App\Http\Controllers\UserController::class)->except('create', 'edit');
        Route::get('/ubigeo', [\App\Http\Controllers\UbigeoController::class, 'ubigeo']);
    });
    // recurso comunes
    Route::resource('/entidad', \App\Http\Controllers\EntidadController::class)->only('index');
    Route::resource('/departamentos', \App\Http\Controllers\DepartmentController::class)->only('index');
    Route::resource('/distritos', \App\Http\Controllers\DistritoController::class)->only('index');
    Route::resource('/provincias', \App\Http\Controllers\ProvinciaController::class)->only('index');

    Route::get('/directorio', [\App\Http\Controllers\Directorio\DirectorioController::class, 'index']);
    Route::get('/directorio/entidades_registradas', [\App\Http\Controllers\Directorio\DirectorioController::class, 'entidades']);
    Route::resource('/directorio/responsables', \App\Http\Controllers\Directorio\ResponsableController::class)->except('create', 'edit');
    Route::get('/directorio/categorias', [\App\Http\Controllers\Directorio\ResponsableController::class, 'categorias']);
    Route::get('/directorio/roles', [\App\Http\Controllers\Directorio\ResponsableController::class, 'roles']);
    Route::get('/directorio/cargos', [\App\Http\Controllers\Directorio\ResponsableController::class, 'cargos']);

    //Route::resource('/monitoreo/respuestas', \App\Http\Controllers\Monitoreo\RespuestaController::class)->except('create', 'edit');
    //Route::resource('/seguimiento/respuestas', \App\Http\Controllers\Seguimiento\RespuestaController::class)->except('create', 'edit');
    //Route::resource('/supervision/respuestas', \App\Http\Controllers\Supervision\RespuestaController::class)->except('create', 'edit');
    //Route::get('/evaluacion/resumen', [\App\Http\Controllers\Evaluacion\ResumenController::class, 'resumen'])->name('evaluacion.resumen');

});
//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
