<?php


namespace App\Components\Route;

/**
 * Class RouterStorage
 * @package App\Components\Route
 */
class RouterStorage
{


    /**
     * @var array
     */
    private static ?array  $mainRouter=[];


    /**
     * @param MainRouter $mainRouter
     */
    public static function add(MainRouter $mainRouter): void
    {
        self::setRouteNames($mainRouter);
        self::$mainRouter[] = $mainRouter;
    }

    private static function setRouteNames(MainRouter $mainRouter): void
    {
        RouterName::setName(
            $mainRouter->getName(),
            [
                'router_url' => $mainRouter->getDynamicUrl(),
                'real_url' => $mainRouter->getUrlPath()
            ]
        );
    }


    /**
     * @return array|MainRouter[]
     */
    public static function all(): array
    {
        return self::$mainRouter;
    }
}
