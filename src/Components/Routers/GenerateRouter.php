<?php


namespace App\Components\Routers;


/**
 * Class GenerateRouter
 * @package App\Components\Routers
 */
class GenerateRouter
{

    /**
     * @param string $name
     * @param array $parameters
     * @return string
     */
    public function router(string $name, array $parameters = []): string
    {
        $routeUrl = RouterName::getName($name)['router_url'];

        foreach ($parameters as $key => $value) {

            $routeUrl = str_replace($key, $value, $routeUrl);
        }
        return url()->base() . '/' . $routeUrl;
    }
}