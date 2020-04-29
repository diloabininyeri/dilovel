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
    public function url(string $name, array $parameters = []): string
    {
        $routeUrl = RouterName::getName($name)['router_url'];
        if (!empty($parameters)) {
            foreach ($parameters as $key => $value) {

                $routeUrl = str_replace(':' . $key, $value, $routeUrl);
            }
        }
        return url()->base() . '/' . $routeUrl;
    }
}