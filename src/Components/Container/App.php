<?php


namespace App\Components\Container;

use Closure;

/**
 * Class App
 * @package App\Components\Container
 */
class App
{


    /**
     * @param $name
     * @param Closure $closure
     */
    public function register($name, Closure $closure):void
    {
        AppContainer::add($name, $closure);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        return call_user_func(AppContainer::get($name));
    }
}
