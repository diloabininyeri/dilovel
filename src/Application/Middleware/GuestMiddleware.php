<?php


namespace App\Application\Middleware;

use App\Components\Auth\User\Auth;
use App\Components\Http\Request;
use App\Interfaces\MiddlewareInterface;
use Closure;

/**
 * Class GuestMiddleware
 * @package App\Application\Middleware
 */
class GuestMiddleware implements MiddlewareInterface
{
    /**
     * @param Closure $next
     * @param Request $request
     * @return false|mixed|string
     */
    public function handle(Closure $next, Request $request)
    {
        if (!Auth::user()->check()) {
            return $next($request);
        }
        http_response_code(404);
        return  view('errors.404');
    }
}
