<?php

use App\Http\Middleware\keycloakMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use KeycloakGuard\KeycloakGuard;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //aqui adicionamos middleware globais onde todas as rotas precisarão passar por ele

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })

    ->create();
