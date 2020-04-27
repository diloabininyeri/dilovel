<?php


namespace App\Application\Middlewares;


use App\Components\Http\Request;
use App\interfaces\MiddlewareInterface;
use Closure;

/**
 * Class RequestIdMustBeInt
 * @package App\Http\Middleware
 */
class RequestIdMustBeInteger implements MiddlewareInterface
{

    /**
     * @param Closure $next
     * @param $request
     * @return mixed
     */
    public function handle(Closure $next, Request $request)
    {
        return  $next($request);
    }
}