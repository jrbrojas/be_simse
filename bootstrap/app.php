<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Dotenv\Dotenv;

// Ruta base del proyecto
$basePath = dirname(__DIR__);

// Crear app
$app = Application::configure(basePath: $basePath)
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append([\Illuminate\Http\Middleware\HandleCors::class]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    });

if (file_exists($basePath.'/.env')) {
    Dotenv::createMutable($basePath)->load();
}
$externalPath = $basePath.'/../.env';
if (file_exists($externalPath)) {
    Dotenv::createMutable(dirname($externalPath), basename($externalPath))->load();
}

return $app->create();

