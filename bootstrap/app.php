<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        // Tetap daftarkan alias agar middleware role dikenali [cite: 82, 83]
        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureRole::class,
        ]);
        
        // JANGAN gunakan redirectUsersTo di sini karena akan bentrok dengan role lain.
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();