<?php


namespace App\Application\Middleware;


use App\Components\Http\Request;
use App\Interfaces\MiddlewareInterface;
use Closure;

/**
 * Class GlobalMiddleware
 * @package App\Application\Middleware
 */
class GlobalMiddleware implements MiddlewareInterface
{

    /**
     * @param Closure $next
     * @param Request $request
     * @return mixed
     */
    public function handle(Closure $next, Request $request)
    {
        return $next($request);
    }
}