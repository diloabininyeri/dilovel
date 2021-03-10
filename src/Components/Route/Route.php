<?php


namespace App\Components\Route;

use App\Interfaces\PseudoRouteInterface;
use Closure;
use function Composer\Autoload\includeFile;

/**
 * Class Route
 * @package App\Components\Route
 * @method static PseudoRouteInterface get($urlPattern, $callback=null)
 * @method static PseudoRouteInterface post($urlPattern, $callback=null)
 * @method PseudoRouteInterface authorize(Closure $callback)
 * @method static PseudoRouteInterface view(string $uri,string $view)
 */
class Route
{

    /**
     * @param $name
     * @param $arguments
     * @return MainRouter
     */
    public static function __callStatic($name, $arguments)
    {
        if ($name === 'view') {
            return (new MainRouter())
                ->view($arguments[1])
                ->setDynamicUrl($arguments[0])
                ->setMethod('GET');
        }
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
    }

    /**
     * @param $attributes
     * @param $callback
     */
    public static function group($attributes, $callback): void
    {
        $prevRouters=RouterStorage::all();
        $startIndexNow=count($prevRouters);
        $callback();
        $nowRouters=RouterStorage::all();
        $lastIndexNow=count($nowRouters)-1;

        $routers=array_slice($nowRouters, $startIndexNow, $lastIndexNow);
        (new GenerateRouterGroup($attributes, $routers))
            ->updateNameAndPrefix()
            ->updateMiddleware()
            ->updateNamespace();
    }

    /**
     * @param string $namespace
     * @param Closure $closure
     */
    public static function prefix(string $namespace, Closure $closure): void
    {
        self::group(['namespace'=>$namespace], $closure);
    }

    public static function middleware(array $middleware, Closure $closure):void
    {
        self::group(['middleware'=>$middleware], $closure);
    }

    /**
     * @param string $name
     * @param Closure $closure
     */
    public static function name(string $name, Closure $closure):void
    {
        self::group(['name'=>$name], $closure);
    }

    /**
     * @param $path
     */
    public static function path($path): void
    {
        $routerPath=str_replace('.', '/', $path);
        includeFile("src/Route/$routerPath.php");
    }
    /**
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        if ($name === 'path') {
            $routerPath=str_replace('.', '/', $arguments[0]);
            includeFile("src/Route/$routerPath.php");
        }
    }

    /**
     * @param array $ip
     * @param Closure $closure
     * @return mixed
     */
    public static function ip(array $ip, Closure $closure)
    {
        if (in_array(request()->ip(), $ip, true)) {
            return $closure();
        }
        return  null;
    }
}
