<?php

use Illuminate\Support\Facades\Route;

Route::get('/files/{file}', [\App\Http\Controllers\FileController::class, 'file'])->name('files.show');
//visualizar archivos adjuntos
Route::get('/files/{type}/{id}', [\App\Http\Controllers\FileController::class, 'show'])->name('anyfiles.show');
Route::get('/', function () {
    return view('welcome');
});



