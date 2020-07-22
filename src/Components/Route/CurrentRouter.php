<?php


namespace App\Components\Route;

/**
 * Class CurrentRouter
 * @package App\Components\Route
 */
class CurrentRouter
{
    /**
     * @var RouterObject
     */
    private static RouterObject $mainRouter;

    /**
     * @param RouterObject $mainRouter
     */
    public static function set(RouterObject $mainRouter): void
    {
        self::$mainRouter = $mainRouter;
    }

    /**
     * @return RouterObject
     */
    public static function get(): RouterObject
    {
        return self::$mainRouter;
    }
}
