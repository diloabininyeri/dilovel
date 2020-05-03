<?php


namespace App\Interfaces;

use App\Components\Http\Request;
use Closure;

/**
 * Interface MiddlewareInterface
 * @package App\interfaces
 */
interface MiddlewareInterface
{

    /**
     * @param Closure $next
     * @param $request
     * @return mixed
     */
    public function handle(Closure $next, Request $request);
}
