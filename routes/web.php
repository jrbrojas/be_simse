<?php

use Illuminate\Support\Facades\Route;

Route::get('/files/{file}', [\App\Http\Controllers\FileController::class, 'show'])->name('files.show');
Route::get('/', function () {
    return view('welcome');
});



