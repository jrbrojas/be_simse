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
        // recurso comunes
        Route::get('/entidades', [\App\Http\Controllers\EntidadController::class, 'index']);
        Route::get('/departamentos', [\App\Http\Controllers\DepartmentController::class ,'index']);
        Route::get('/distritos', [\App\Http\Controllers\DistritoController::class, 'index']);
        Route::get('/provincias', [\App\Http\Controllers\ProvinciaController::class, 'index']);
        Route::get('/categorias', [\App\Http\Controllers\CategoriaController::class, 'index']);
        Route::get('/roles', [\App\Http\Controllers\RolesResponsableController::class, 'index']);
        Route::get('/cargos', [\App\Http\Controllers\CargoController::class, 'index']);

        // rutas de usuarios
        Route::apiResource('/usuarios', \App\Http\Controllers\UserController::class);

        // rutas de directorio
        Route::apiResource('/directorio', \App\Http\Controllers\Directorio\DirectorioController::class);

        // rutas de responsables
        Route::apiResource('/responsables', \App\Http\Controllers\Directorio\ResponsableController::class);

        // rutas de monitoreo
        Route::apiResource('/monitoreo', \App\Http\Controllers\Monitoreo\MonitoreoController::class);
        Route::get('/monitoreo/respuestas', [\App\Http\Controllers\Monitoreo\RespuestaController::class, 'index']);
        Route::get('/monitoreo/pdf', [\App\Http\Controllers\Monitoreo\RespuestaController::class, 'exportPdf'])->name('monitoreo.entidad.pdf');

        // seguimiento
        Route::apiResource('/seguimiento', \App\Http\Controllers\Seguimiento\SeguimientoController::class);
        Route::get('/seguimiento/respuestas', [\App\Http\Controllers\Seguimiento\RespuestaController::class, 'index']);
        Route::get('/seguimiento/pdf', [\App\Http\Controllers\Seguimiento\RespuestaController::class, 'exportPdf'])->name('seguimiento.entidad.pdf');

        // supervision @todo terminar
        Route::apiResource('/supervision', [\App\Http\Controllers\Supervision\SupervisionController::class, 'index']); // opcional si quieres listar todo
        Route::get('/supervision/{id}', [\App\Http\Controllers\Supervision\SupervisionController::class, 'show']);
        Route::post('/supervision/respuestas', [\App\Http\Controllers\Supervision\SupervisionController::class, 'store']);
        Route::get('/supervision/entidades_registradas/{entidad}', [\App\Http\Controllers\Supervision\SupervisionEntidadRegistradaController::class, 'getEntidad']);
        Route::get('/supervision/entidades_registradas/{entidad}/historial', [\App\Http\Controllers\Supervision\SupervisionEntidadRegistradaController::class, 'historial']);
        Route::get('/supervision/entidades_registradas/{entidad}/pdf', [\App\Http\Controllers\Supervision\SupervisionEntidadRegistradaController::class, 'exportPdf'])->name('monitoreo.entidad.pdf');

    });



    // Evaluacion
    Route::get('/evaluacion/resumen/{entidad}', [\App\Http\Controllers\Evaluacion\ResumenController::class, 'resumen'])->name('evaluacion.resumen');
    Route::get('/evaluacion/resumen-categoria', [\App\Http\Controllers\Evaluacion\ResumenController::class, 'resumenCategoria'])->name('evaluacion.categoria.resumen');
});
