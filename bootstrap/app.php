<?php

use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Log;
use App\Exceptions\BusinessException;
use Illuminate\Foundation\Application;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (BusinessException $e, $request) {
            Log::error('BusinessException : ' . $e->getMessage());
            if ($request->expectsJson()) {
                return ApiResponse::error(
                    $e->getMessage(),
                    $e->statusCode
                );
            }
        });

        $exceptions->render(function (ValidationException $e, $request) {
            if ($request->expectsJson()) {
                Log::error('ValidationException : Os dados fornecidos são inválidos');
                Log::error($e->errors());
                return ApiResponse::validationError(
                    $e->errors(),
                    'Os dados fornecidos são inválidos'
                );
            }
        });

        $exceptions->render(function (ModelNotFoundException $e, $request) {
            if ($request->expectsJson()) {
                Log::error('ModelNotFoundException : Recurso nao encontrado');
                return ApiResponse::notFound(
                    'Recurso não encontrado'
                );
            }
        });

        $exceptions->render(function (AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                Log::error('AuthenticationException :' . $e->getMessage());
                return ApiResponse::unauthorized(
                    $e->getMessage() ?: 'Não autenticado'
                );
            }
        });

        $exceptions->render(function (HttpException $e, $request) {
            if ($request->expectsJson()) {
                return ApiResponse::error(
                    $e->getMessage() ?: 'Erro na requisição',
                    $e->getStatusCode()
                );
            }
        });

        $exceptions->render(function (\Throwable $e, $request) {
            if ($request->expectsJson()) {
                return ApiResponse::serverError(
                    app()->environment('production')
                        ? 'Erro interno do servidor'
                        : $e->getMessage()
                );
            }
        });
    })->create();
