<?php


namespace App\Application\Middleware;


use App\Components\Http\Request;
use App\Interfaces\MiddlewareInterface;
use Closure;

/**
 * Class TestExample
 * @package App\Application\Middleware
 */
class TestExample implements MiddlewareInterface
{


    /**
     * @param Closure $next
     * @param Request $request
     * @return mixed|string
     */
    public function handle(Closure $next, Request $request)
    {
        return 'cant passed';
    }
}