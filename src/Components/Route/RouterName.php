<?php


namespace App\Components\Route;

use RuntimeException;

/**
 * Class RouterName
 * @package App\Components\Route
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
     * @param $name
     * @param $value
     * @return string
     */
    public static function addBeginningDynamicUrl($name, $value):string
    {
        return self::$names[$name]['router_url'] = trim($value, '/') . '/' . self::$names[$name]['router_url'];
    }
    /**
     * @param $oldName
     * @param $newName
     * @param null $newValue
     * @return mixed|null
     */
    public static function update($oldName, $newName, $newValue=null)
    {
        $oldValue=self::$names[$oldName];
        unset(self::$names[$oldName]);
        return self::$names[$newName]=$newValue ?: $oldValue;
    }
    /**
     * @return array
     */
    public static function all(): array
    {
        return self::$names;
    }
}
