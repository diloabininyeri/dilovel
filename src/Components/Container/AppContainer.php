<?php


namespace App\Components\Container;

use Closure;

/**
 * Class AppContainer
 * @package App\Components\Container
 */
class AppContainer
{
    /**
     * @var array
     */
    private static array $containers = [];

    /**
     * @param $name
     * @param Closure $callable
     */
    public static function add($name, Closure $callable): void
    {
        if (!isset(self::$containers[$name])) {
            self::$containers[$name] = $callable;
        }
    }

    /**
     * @param $name
     * @return mixed
     */
    public static function get($name)
    {
        return self::$containers[$name];
    }
}
