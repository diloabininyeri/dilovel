<?php

namespace App\Application;

use App\Application\Middleware\AuthMiddleware;
use App\Application\Middleware\CaptchaVerifyMiddleware;
use App\Application\Middleware\CsrfTokenMiddleware;
use App\Application\Middleware\GlobalMiddleware;
use App\Application\Middleware\GuestMiddleware;
use App\Application\Middleware\NameMiddleware;
use App\Application\Middleware\RequestIdMustBeInteger;
use App\Application\Middleware\TestExample;
use App\Application\Middleware\ThrottleMiddleware;
use App\Components\Http\MiddlewareAbstract;

/**
 * Class Middleware
 * @package App\app
 */
class Middleware extends MiddlewareAbstract
{
    /**
     * @var array|string[]
     */
    protected array $middleware = [

        'must_be_int' => RequestIdMustBeInteger::class,
        'name' => NameMiddleware::class,
        'example' => TestExample::class,
        'auth' => AuthMiddleware::class,
        'guest'=>GuestMiddleware::class,
        'csrf' => CsrfTokenMiddleware::class,
        'captcha'=>CaptchaVerifyMiddleware::class,
        'throttle'=>ThrottleMiddleware::class,

    ];

    /**
     * this middleware working every route
     * @var array|string[]
     */
    protected array $global = [
        GlobalMiddleware::class,
        CsrfTokenMiddleware::class,
    ];
}
