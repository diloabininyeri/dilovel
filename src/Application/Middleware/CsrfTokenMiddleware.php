<?php


namespace App\Application\Middleware;

use App\Application\Middleware\Abstracts\AbstractCsrfTokenMiddleware;
use App\Components\Http\Request;
use App\Interfaces\MiddlewareInterface;
use Closure;

/**
 * Class CsrfTokenMiddleware
 * @package App\Application\Middleware
 */
class CsrfTokenMiddleware extends AbstractCsrfTokenMiddleware implements MiddlewareInterface
{

    /**
     * @var array|string[]
     */
    protected array $except = [
        'payment'
    ];

    /**
     * trigger validate token when those post
     * @var array|string[]
     */
    protected array $methods = [
        'POST', 'PUT', 'DELETE',
    ];

    /**
     * @param Closure $next
     * @param Request $request
     * @return false|mixed|string
     */
    public function handle(Closure $next, Request $request)
    {
        if ($this->isCanPass($request)) {
            return $next($request);
        }
        return $this->returnError($request);
    }
}
