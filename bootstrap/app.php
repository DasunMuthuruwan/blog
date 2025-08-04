<?php

use App\Http\Middleware\BlockAnonymousProxies;
use App\Http\Middleware\BlockCrawlers;
use App\Http\Middleware\OnlySuperAdminAccessPagesMiddleware;
use App\Http\Middleware\PreventBackHistoryMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->prependToGroup('web', [
            BlockCrawlers::class,
            // BlockAnonymousProxies::class
        ])
            ->alias([
                'prevent-back-history' => PreventBackHistoryMiddleware::class,
                'only-access-super-admin' => OnlySuperAdminAccessPagesMiddleware::class
            ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
