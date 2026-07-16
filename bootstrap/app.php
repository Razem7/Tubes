<?php

use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsMerchant;
use App\Http\Middleware\IsNotAdmin;
use App\Http\Middleware\IsSuperAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin'       => IsAdmin::class,
            'super_admin' => IsSuperAdmin::class,
            'merchant'    => IsMerchant::class,
            'not_admin'   => IsNotAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
