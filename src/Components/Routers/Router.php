<?php


namespace App\Components\Routers;

use App\Components\Http\Request;
use App\Interfaces\PseudoRouteInterface;
use Closure;
use function Composer\Autoload\includeFile;

/**
 * Class Router
 * @package App\Components\Routers
 * @method static PseudoRouteInterface get($urlPattern, $callback)
 * @method static PseudoRouteInterface post($urlPattern, $callback)
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
     */
    public static function __callStatic($name, $arguments)
    {
        return (new MainRouter())
            ->setDynamicUrl($arguments[0])
            ->setSecondParameter($arguments[1])
            ->setMethod($name);
    }

    /**
     * @param string $class
     * @param string $method
     * @param Closure $closure
     * @return mixed
     */
    public static function auth(string $class, string $method, Closure $closure=null)
    {
        return new RouterAuth($class, $method, $closure);
        /*if (call_user_func([new $class(), $method], new Request())) {
             return $closure();
         }*/
    }

    /**
     * @param $attributes
     * @param $callback
     */
    public static function group($attributes, $callback): void
    {
        (new MainRouter())->group($attributes, $callback);
    }

    /**
     * @param string $path
     */
    public function path(string $path): void
    {
        $routerPath=str_replace('.', '/', $path);
        includeFile("src/Routers/$routerPath.php");
    }
}
