<?php


namespace App\Components\Route;

/**
 * Class NotFound
 * @package App\Components\Route
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
