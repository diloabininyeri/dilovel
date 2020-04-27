<?php

namespace App\Application;

use App\Application\Middlewares\NameMiddleware;
use App\Application\Middlewares\RequestIdMustBeInteger;
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
        'name' => NameMiddleware::class

    ];
}