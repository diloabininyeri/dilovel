<?php


namespace App\Components\Routers;

/**
 * Class NotFound
 * @package App\Components
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
