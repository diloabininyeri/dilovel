<?php


namespace App\Components;

use App\Components\Cache\MainCache;
use App\Components\Cache\Redis\Redis;
use App\Components\String\StrComponent;
use Closure;

/**
 * Class Cache
 * @package App\Components
 * @method static remember($key, Closure $closure,int  $seconds=120)
 * @method static get(string $key, $default = null)
 * @method static set(string $key, $value)
 * @method static setex(string $key, $value, $time = 120)
 * @method static bool exists(string $key)
 * @method static StrComponent getString(string $key)
 *
 */
class Cache
{

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return (new MainCache())->$name(...$arguments);
    }
}
