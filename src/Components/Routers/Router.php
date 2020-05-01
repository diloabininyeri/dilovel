<?php


namespace App\Components\Routers;


use App\Components\Http\Request;
use App\Interfaces\PseudoRouteInterface;
use Closure;

/**
 * Class Router
 * @package App\Components\Routers
 * @method static PseudoRouteInterface get($urlPattern,$callback)
 * @method static PseudoRouteInterface post($urlPattern,$callback)
 * @method PseudoRouteInterface middleware()
 * @method PseudoRouteInterface name
 * @method PseudoRouteInterface authorize(Closure $callback)
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

    /**
     * @param string $class
     * @param string $method
     * @param Closure $closure
     * @return mixed
     */
    public static function auth(string $class, string $method, Closure $closure)
    {
        if (call_user_func([new $class(), $method],new Request())) {
            return $closure();
        }
    }

    /**
     * @param $attributes
     * @param $callback
     */
    public static function group($attributes, $callback): void
    {
        (new MainRouter())->group($attributes, $callback);

    }
}