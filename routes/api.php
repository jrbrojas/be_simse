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

    // directorio
    Route::get('/directorio', [\App\Http\Controllers\Directorio\DirectorioController::class, 'index']);
    Route::get('/directorio/entidades_registradas', [\App\Http\Controllers\Directorio\DirectorioController::class, 'entidades']);
    Route::get('/directorio/entidades_registradas/{entidad}', [\App\Http\Controllers\Directorio\DirectorioController::class, 'getEntidad']);
    Route::resource('/directorio/responsables', \App\Http\Controllers\Directorio\ResponsableController::class)->except('create', 'edit');
    Route::get('/directorio/categorias', [\App\Http\Controllers\Directorio\ResponsableController::class, 'categorias']);
    Route::get('/directorio/roles', [\App\Http\Controllers\Directorio\ResponsableController::class, 'roles']);
    Route::get('/directorio/cargos', [\App\Http\Controllers\Directorio\ResponsableController::class, 'cargos']);
    Route::get(
        '/directorio/exportar-excel',
        [\App\Http\Controllers\Directorio\DirectorioController::class, 'exportarExcel'],
    )->name("directorio.exportar-excel");

    // monitoreo
    Route::get('/monitoreo', [\App\Http\Controllers\Monitoreo\MonitoreoController::class, 'index']);
    Route::get('/monitoreo/respuestas', [\App\Http\Controllers\Monitoreo\RespuestaController::class, 'index']);
    Route::post('/monitoreo/respuestas', [\App\Http\Controllers\Monitoreo\RespuestaController::class, 'store']);
    Route::get('/monitoreo/entidades_registradas/{entidad}', [\App\Http\Controllers\Monitoreo\EntidadRegistradaController::class, 'getEntidad']);
    Route::get('/monitoreo/entidades_registradas/{entidad}/historial', [\App\Http\Controllers\Monitoreo\EntidadRegistradaController::class, 'historial']);

    // nueva ruta pdf
    Route::get('/monitoreo/entidades_registradas/{entidad}/pdf', [\App\Http\Controllers\Monitoreo\EntidadRegistradaController::class, 'exportPdf'])->name('monitoreo.entidad.pdf');

    // seguimiento
    Route::get('/seguimiento', [\App\Http\Controllers\Seguimiento\SeguimientoController::class, 'index']);
    Route::get('/seguimiento/{id}', [\App\Http\Controllers\Seguimiento\SeguimientoController::class, 'show']);
    Route::get('/seguimiento/entidades_registradas/{entidad}', [\App\Http\Controllers\Seguimiento\EntidadRegistradaController::class, 'getEntidad']);
    Route::get('/seguimiento/entidades_registradas/{entidad}/historial', [\App\Http\Controllers\Seguimiento\EntidadRegistradaController::class, 'historial']);
    Route::post('/seguimiento/respuestas', [\App\Http\Controllers\Seguimiento\RespuestaController::class, 'store']);
    Route::get('/seguimiento/entidades_registradas/{entidad}/pdf', [\App\Http\Controllers\Seguimiento\EntidadRegistradaController::class, 'exportPdf'])->name('monitoreo.entidad.pdf');

    // supervision
    Route::get('/supervision', [\App\Http\Controllers\Supervision\SupervisionController::class, 'index']); // opcional si quieres listar todo
    Route::get('/supervision/{id}', [\App\Http\Controllers\Supervision\SupervisionController::class, 'show']);
    Route::post('/supervision/respuestas', [\App\Http\Controllers\Supervision\SupervisionController::class, 'store']);
    Route::get('/supervision/entidades_registradas/{entidad}', [\App\Http\Controllers\Supervision\SupervisionEntidadRegistradaController::class, 'getEntidad']);
    Route::get('/supervision/entidades_registradas/{entidad}/historial', [\App\Http\Controllers\Supervision\SupervisionEntidadRegistradaController::class, 'historial']);
    Route::get('/supervision/entidades_registradas/{entidad}/pdf', [\App\Http\Controllers\Supervision\SupervisionEntidadRegistradaController::class, 'exportPdf'])->name('monitoreo.entidad.pdf');

    // Evaluacion
    Route::get('/evaluacion/resumen/{entidad}', [\App\Http\Controllers\Evaluacion\ResumenController::class, 'resumen'])->name('evaluacion.resumen');
    Route::get('/evaluacion/resumen-categoria', [\App\Http\Controllers\Evaluacion\ResumenController::class, 'resumenCategoria'])->name('evaluacion.categoria.resumen');
});
