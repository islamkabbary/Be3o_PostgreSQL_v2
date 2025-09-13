<?php

use App\Http\Middleware\CorsMiddleware;
use App\Http\Middleware\SetLanguageMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Log;
use App\Traits\ResponseTrait;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [
            CorsMiddleware::class,
            SetLanguageMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // استخدام ResponseTrait ديناميكيًا
        $responseTrait = new class { use ResponseTrait; };

        // التعامل مع جميع الاستثناءات للـ API
        $exceptions->render(function (Throwable $e, Request $request) use ($responseTrait) {
            if (!$request->is('api/*')) {
                throw $e; // لو مش API يرجع الاستثناء الطبيعي
            }

            $statusCode = 500;
            $message = 'Internal Server Error';
            $errors = [];

            // Validation Exception
            if ($e instanceof ValidationException) {
                $statusCode = 422;
                $errors = $e->errors();
                $message = $e->validator->errors()->first() ?: $message;
                return $responseTrait->error($errors, $message, $statusCode);
            }

            // Authentication Exception
            if ($e instanceof AuthenticationException) {
                $statusCode = 401;
                $message = 'غير مصرح لك. يجب تسجيل الدخول أولاً.';
            }

            // Not Found / Model Not Found
            if ($e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException) {
                $statusCode = 404;
                $message = 'Resource not found';
            }

            // أي Exception عام مع كود صالح
            if ($e instanceof \Exception) {
                $code = $e->getCode();
                if ($code >= 100 && $code < 600) {
                    $statusCode = $code;
                }
                $message = $e->getMessage() ?: $message;
            }

            return $responseTrait->error($errors, $message, $statusCode);
        });

    })
    ->create();
