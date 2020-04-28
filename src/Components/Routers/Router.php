<?php


namespace App\Components\Routers;


/**
 * Class Router
 * @package App\Routers\Components
 * @method static MainRouter get($url, $callback)
 * @method static post($url, $callback)
 */
class Router
{

    /**
     * @param $name
     * @param $arguments
     * @return MainRouter
     *
     * @noinspection PhpInconsistentReturnPointsInspection
     */
    public static function __callStatic($name, $arguments)
    {
        if ($_SERVER['REQUEST_METHOD'] === strtoupper($name)) {
            return (new MainRouter())
                ->setDynamicUrl($arguments[0])
                ->setSecondParameter($arguments[1]);

        }
    }

    public static function group($attributes, $callback):void
    {
        (new MainRouter())->group($attributes,$callback);

    }
}