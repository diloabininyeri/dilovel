<?php


namespace App\Application\Middleware;

use App\Components\Http\Request;
use App\Interfaces\MiddlewareInterface;
use Closure;
use Throttle\Throttle;
use Throttle\Time;

/**
 * Class ThrottleMiddleware
 * @package App\Application\Middleware
 */
class ThrottleMiddleware implements MiddlewareInterface
{

    /**
     * @param Closure $next
     * @param Request $request
     * @return mixed|void
     */
    public function handle(Closure $next, Request $request)
    {
        $throttle = new Throttle(new Time(40, 10));
        $throttle->commit();
        if ($throttle->isHasAccessLimit()) {
            return $next($request);
        }
        return abort(403);
    }
}
