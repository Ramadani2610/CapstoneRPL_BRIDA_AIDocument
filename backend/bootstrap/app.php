<?php

use App\Http\Middleware\CatatAudit;
use App\Http\Middleware\PastikanApiJson;
use App\Http\Middleware\PastikanRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Route middleware aliases, used as 'role:admin' and friends.
        $middleware->alias([
            'role' => PastikanRole::class,
        ]);

        // Always answer JSON for /api/* requests.
        $middleware->append(PastikanApiJson::class);

        // Audit trail: every /api/* request that changes data.
        $middleware->api(append: [CatatAudit::class]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
