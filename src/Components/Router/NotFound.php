<?php


namespace App\Components\Router;

/**
 * Class NotFound
 * @package App\Components\Router
 */
class NotFound
{
    public static int  $isNotFound=0;
    /**
     * @return bool
     */
    public static function isCannotFindAny():bool
    {
        return self::$isNotFound===0;
    }
}
