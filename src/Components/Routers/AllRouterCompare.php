<?php


namespace App\Components\Routers;


/**
 * Class AllRouterCompare
 * @package App\Components\Routers
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

            if ($this->isDynamicAndRealUrlEqual($router)) {
                $this->foundedAnyRoute();
                return new RouterObject($router);
            }

        }
        return  null;

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
        return count(explode('/', $router->getDynamicUrl(), '/')) === count(explode('/', $router->getUrlPath()));
    }
}