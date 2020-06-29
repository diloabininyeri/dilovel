<?php


namespace App\Application\Middleware;

use App\Components\Http\Request;
use App\Components\Lang\Lang;
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
        $yourCondition = true;

        if ($yourCondition) {
            return $next($request);
        }
        return view('errors.404');
    }
}
