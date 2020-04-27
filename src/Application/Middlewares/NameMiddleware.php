<?php


namespace App\Application\Middlewares;


use App\Components\Http\Request;
use App\interfaces\MiddlewareInterface;
use Closure;

/**
 * Class NameMiddleware
 * @package App\app\Middlewares
 */
class NameMiddleware implements MiddlewareInterface
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