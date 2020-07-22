<?php


namespace App\Bootstrap;

use App\Application\Middleware;
use App\Components\Http\Request;
use Closure;

/**
 * Class GlobalMiddlewareLayer
 * @package App\Bootstrap
 * @property-read $global
 * @see Middleware::$global get $this->global variable from Middleware class with  call closure event protected variable
 */
class GlobalMiddlewareLayer
{

    /**
     * @return Closure
     */
    public function bind(): Closure
    {
        return function () {
            $request =Request::getInstance();
            /**
             * @see Middleware::$global
             */
            foreach ($this->global as $middleware) {
                if ($request instanceof Request) {
                    $request = (new $middleware)->handle(fn ($response) => $response, $request);
                } else {
                    break;
                }
            }

            return $request;
        };
    }
}
