<?php


namespace App\Application\Middleware;

use App\Components\Csrf\CsrfGuard;
use App\Components\Http\Request;
use App\Interfaces\MiddlewareInterface;
use Closure;

/**
 * Class CsrfTokenMiddleware
 * @package App\Application\Middleware
 */
class CsrfTokenMiddleware implements MiddlewareInterface
{

    /**
     * @param Closure $next
     * @param Request $request
     * @return false|mixed|string
     */
    public function handle(Closure $next, Request $request)
    {
        if ($request->method() === 'POST') {
            $csrf = new CsrfGuard();
            if (!$csrf->validateToken($request->post('_token') ?? '')) {
                return view(500, ['error'=>' csrf must be verify']);
            }
        }

        return $next($request);
    }
}
