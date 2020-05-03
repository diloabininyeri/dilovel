<?php

use App\Application\Middleware;
use App\Bootstrap\App;
use App\Bootstrap\GlobalMiddlewareLayer;
use App\Components\Http\Request;
use App\Components\Shutdown\App as AppShutdown;

require_once 'vendor/autoload.php';

/**
 * activates errors to see errors in the app
 */
activate_errors();


$globalMiddleware= (new GlobalMiddlewareLayer())->bind()->call(new Middleware());

if ($globalMiddleware instanceof Request) {
    echo (new App())
        ->run()
        ->call404IfNotFound();
} else {
    echo $globalMiddleware;
}


(new AppShutdown())->onShutdown();
