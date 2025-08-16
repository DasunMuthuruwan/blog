<?php

use App\Http\Middleware\BlockAnonymousProxies;
use App\Http\Middleware\BlockCrawlers;
use App\Http\Middleware\OnlySuperAdminAccessPagesMiddleware;
use App\Http\Middleware\PreventBackHistoryMiddleware;
use Egulias\EmailValidator\Parser\PartParser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Exceptions\UrlGenerationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'prevent-back-history' => PreventBackHistoryMiddleware::class,
            'only-access-super-admin' => OnlySuperAdminAccessPagesMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $reportableExceptions = [
            AuthenticationException::class,
            AuthorizationException::class,
            ValidationException::class,
            TokenMismatchException::class,
            ModelNotFoundException::class,
            UnauthorizedException::class,
            UrlGenerationException::class,
            InvalidParameterException::class,
            MissingMandatoryParametersException::class,
            BadRequestException::class,
            MethodNotAllowedHttpException::class,
            HttpException::class,
            PartParser::class,
            Error::class,
            TypeError::class
        ];
        $exceptions->stopIgnoring($reportableExceptions);
        $exceptions->report(function (Throwable $exception) use ($reportableExceptions) {

            if (in_array(get_class($exception), $reportableExceptions, true)) {
                $meta = [
                    'message' => $exception->getMessage(),
                    'exception' => get_class($exception),
                    'reason' => 'exception-thrown',
                    'url' => request()->fullUrl()
                ];
                if ($exception instanceof ValidationException) {
                    $meta['errors'] = $exception->errors();
                };
                $log = [request()->requestId ?? 'unknown', 'failed', json_encode(['meta' => $meta])];
                Log::channel('request-log')->error(implode(",", $log));
            }
        });

        $exceptions->render(function (Throwable $exception, $request) {
            if ($exception instanceof HttpException) {
                // For Livewire request
                if ($request->hasHeader('X-Livewire')) {
                    return response()->json([], 419);
                }

                // For normal request
                return redirect()->route('home')->with('error', 'Your session has expired. Please try again.');
            }
            if ($exception instanceof AuthenticationException) {
                // If request comes from admin area
                if ($request->is('admin/*')) {
                    return redirect()->guest(route('admin.login'));
                }
                // Otherwise, send guest users to blog home
                return redirect()->guest(route('home'));
            }

            return match (true) {
                $exception instanceof NotFoundHttpException => response()->view('front.pages.errors.404', [], 404),
                $exception instanceof AuthorizationException => response()->view('front.pages.errors.403', [], 403),
                $exception instanceof ParseError || $exception instanceof Error || $exception instanceof TypeError || $exception instanceof InvalidArgumentException => response()->view('front.pages.errors.500', [], 500),
                default => null
            };
        });
    })->create();
