<?php


namespace App\interfaces;


use App\Http\Request;
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