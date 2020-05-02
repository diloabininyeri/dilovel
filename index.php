<?php

use App\{Application\Middleware, Bootstrap\App, Bootstrap\GlobalMiddlewareLayer, Components\Http\Request};


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

}else{ echo $globalMiddleware; }


