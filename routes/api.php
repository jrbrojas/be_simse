<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api', 'prefix' => 'v1'], function () {
    Route::group(['prefix' => 'auth' ], function () {
        Route::post('login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
        Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:api');
        Route::post('refresh', [App\Http\Controllers\AuthController::class, 'refresh'])->middleware('auth:api');
        Route::post('me', [App\Http\Controllers\AuthController::class, 'me'])->middleware('auth:api');
    });

    Route::get('/categorias', [\App\Http\Controllers\CategoriaController::class, 'index']);
    Route::get('/entidades', [\App\Http\Controllers\EntidadController::class, 'index']);
    Route::get('/departamentos', [\App\Http\Controllers\DepartmentController::class ,'index']);
    Route::get('/distritos', [\App\Http\Controllers\DistritoController::class, 'index']);
    Route::get('/provincias', [\App\Http\Controllers\ProvinciaController::class, 'index']);

    Route::get('/directorio', [\App\Http\Controllers\Directorio\DirectorioController::class, 'index']);
    Route::get(
        '/directorio/exportar-excel',
        [\App\Http\Controllers\Directorio\DirectorioController::class, 'exportarExcel'],
    )->name("directorio.exportar-excel");

    // para las tablas
    Route::get('/monitoreo/tabla', [\App\Http\Controllers\Monitoreo\MonitoreoController::class, 'tabla']);
    Route::get('/seguimiento/tabla', [\App\Http\Controllers\Seguimiento\SeguimientoController::class, 'tabla']);
    Route::get('/supervision/tabla', [\App\Http\Controllers\Supervision\SupervisionController::class, 'tabla']);

    Route::get('/evaluacion/resumen-categoria', [\App\Http\Controllers\Evaluacion\ResumenController::class, 'resumenCategoria'])->name('evaluacion.categoria.resumen');

    Route::group(['middleware' => 'auth:api'], function () {
        // recurso comunes
        Route::get('/roles', [\App\Http\Controllers\RolesResponsableController::class, 'index']);
        Route::get('/roles-usuarios', [\App\Http\Controllers\RoleController::class, 'index']);
        Route::get('/cargos', [\App\Http\Controllers\CargoController::class, 'index']);

        Route::get('/entidades/{entidad}/monitoreos', [\App\Http\Controllers\EntidadController::class, 'monitoreos']);
        Route::get('/entidades/{entidad}/seguimientos', [\App\Http\Controllers\EntidadController::class, 'seguimientos']);
        Route::get('/entidades/{entidad}/supervisiones', [\App\Http\Controllers\EntidadController::class, 'supervisiones']);

        // rutas de usuarios
        Route::apiResource('/usuarios', \App\Http\Controllers\UserController::class);

        // rutas de directorio
        Route::apiResource('/directorio', \App\Http\Controllers\Directorio\DirectorioController::class)->except('index');

        // rutas de responsables
        Route::apiResource('/responsables', \App\Http\Controllers\Directorio\ResponsableController::class);

        // rutas de monitoreo
        Route::apiResource('/monitoreo', \App\Http\Controllers\Monitoreo\MonitoreoController::class);
        Route::get('/monitoreo/respuestas', [\App\Http\Controllers\Monitoreo\RespuestaController::class, 'index']);
        Route::get('/monitoreo/{monitoreo}/pdf', [\App\Http\Controllers\Monitoreo\RespuestaController::class, 'exportPdf'])->name('monitoreo.entidad.pdf');

        // seguimiento
        Route::apiResource('/seguimiento', \App\Http\Controllers\Seguimiento\SeguimientoController::class);
        Route::get('/seguimiento/respuestas', [\App\Http\Controllers\Seguimiento\RespuestaController::class, 'index']);
        Route::get('/seguimiento/{seguimiento}/pdf', [\App\Http\Controllers\Seguimiento\RespuestaController::class, 'exportPdf'])->name('seguimiento.entidad.pdf');

        Route::apiResource('/supervision', \App\Http\Controllers\Supervision\SupervisionController::class);
        Route::get('/supervision/respuestas', [\App\Http\Controllers\Supervision\RespuestaController::class, 'index']);
        Route::get('/supervision/{supervision}/pdf', [\App\Http\Controllers\Supervision\RespuestaController::class, 'exportPdf'])->name('supervision.entidad.pdf');

        // Evaluacion
        Route::get('/evaluacion/resumen/{entidad}', [\App\Http\Controllers\Evaluacion\ResumenController::class, 'resumen'])->name('evaluacion.resumen');
    });
});
