<?php


namespace App\Components\Routers;

use RuntimeException;

/**
 * Class RouterName
 * @package App\Components
 */
class RouterName
{

    /**
     * @var array
     */
    private static array $names = [];

    /**
     * @param $name
     * @param $url
     */
    public static function setName($name, $url): void
    {
        self::$names[$name] = $url;
    }

    /**
     * @param $name
     * @return mixed
     */
    public static function getName($name)
    {
        if (isset(self::$names[$name])) {
            return self::$names[$name];
        }
        throw new RuntimeException("$name router not found");
    }

    /**
     * @return array
     */
    public static function all(): array
    {
        return self::$names;
    }
}
