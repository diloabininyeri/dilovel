<?php


namespace App\Components\Routers;


use App\Interfaces\PseudoRouteInterface;

/**
 * Class Router
 * @package App\Components\Routers
 * @method static PseudoRouteInterface get($urlPattern,$callback)
 * @method static PseudoRouteInterface post($urlPattern,$callback)
 * @method PseudoRouteInterface middleware()
 * @method PseudoRouteInterface name
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

    public static function group($attributes, $callback): void
    {
        (new MainRouter())->group($attributes, $callback);

    }
}