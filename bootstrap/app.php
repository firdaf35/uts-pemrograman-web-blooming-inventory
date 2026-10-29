<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (
            HttpExceptionInterface $exception,
            \Illuminate\Http\Request $request
        ) {
            $status = $exception->getStatusCode();

            if (in_array($status, [403, 404])) {
                return response()->view('errors', [
                    'exception' => $exception,
                    'status' => $status,
                ], $status);
            }

            return null;
        });

    })->create();