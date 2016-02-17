<?php

namespace Portal\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Portal\Http\Middleware\EncryptCookies::class,
        \GeneaLabs\LaravelAppleseed\app\Http\Middleware\FaviconInterceptor::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Portal\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Portal\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \Portal\Http\Middleware\RedirectIfAuthenticated::class,
        'ajax' => \Portal\Http\Middleware\AjaxMiddleware::class,
        'FbLogin' => \Portal\Http\Middleware\FbLoginMiddleware::class,
    ];
}
