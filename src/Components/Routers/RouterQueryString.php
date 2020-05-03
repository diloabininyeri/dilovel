<?php


namespace App\Components\Routers;

/**
 * Class RouterQueryString
 * @package App\Components\Routers
 */
class RouterQueryString
{

    /**
     * @var array
     */
    private static array $queryString;

    /**
     * @param $name
     * @param $value
     */
    public static function set($name, $value): void
    {
        self::$queryString[$name] = $value;
    }

    /**
     * @param $name
     * @param null $default
     * @return mixed|null
     */
    public static function get($name, $default = null)
    {
        return self::$queryString[$name] ?? $default;
    }

    /**
     * @return array
     */
    public static function all():array
    {
        return  self::$queryString;
    }
}
