<?php


namespace App\Application\Middleware;

use App\Components\Auth\User\Auth;
use App\Components\Http\Request;
use App\Interfaces\MiddlewareInterface;
use Closure;

/**
 * Class AuthMiddleware
 * @package App\Application\Middleware
 */
class AuthMiddleware implements MiddlewareInterface
{

    /**
     * @param Closure $next
     * @param Request $request
     * @return mixed|void
     */
    public function handle(Closure $next, Request $request)
    {
        if (Auth::user()->check()) {
            return $next($request);
        }
        return abort('errors.404');
    }
}
