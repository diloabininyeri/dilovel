<?php


namespace App\Components\Route;

/**
 * Class AllRouterCompare
 * @package App\Components\Route
 */
class AllRouterCompare
{

    /**
     * @return RouterObject
     */
    public function findWillWhichExecute():?RouterObject
    {
        $routers = RouterStorage::all();
        foreach ($routers as $router) {
            if ($_SERVER['REQUEST_METHOD']===$router->getMethod()) {
                if ($this->isDynamicAndRealUrlEqual($router)) {
                    $this->foundedAnyRoute();
                    return new RouterObject($router);
                }

                if ($this->isEqualCountDynamicAndRealUrl($router) && $this->compareDynamic($router)->isMatched()) {
                    $this->foundedAnyRoute();
                    return new RouterObject($router);
                }
            }
        }
        return  null;
    }


    /**
     * @param $router
     * @return CompareDynamic
     */
    private function compareDynamic($router): CompareDynamic
    {
        return new CompareDynamic($router);
    }


    /**
     * @return int
     */
    private function foundedAnyRoute(): int
    {
        return ++NotFound::$isNotFound;
    }

    /**
     * @param MainRouter $router
     * @return bool
     */
    private function isDynamicAndRealUrlEqual(MainRouter $router): bool
    {
        return (new Compare())->url($router)->isEqual();
    }

    /**
     * @param MainRouter $router
     * @return bool
     */
    private function isEqualCountDynamicAndRealUrl(MainRouter $router): bool
    {
        return count(explode('/', $router->getDynamicUrl())) === count(explode('/', $router->getUrlPath()));
    }
}
