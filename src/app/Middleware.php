<?php

namespace App\app;

use App\app\Middlewares\NameMiddleware;
use App\app\Middlewares\RequestIdMustBeInteger;

/**
 * Class Middleware
 * @package App\app
 */
class Middleware
{

    /**
     * @var array|string[]
     */
    protected array $middleware = [

        'must_be_int' => RequestIdMustBeInteger::class,
        'name' => NameMiddleware::class

    ];
}