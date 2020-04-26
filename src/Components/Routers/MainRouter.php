<?php

namespace App\Components\Routers;


use App\Components\Http\Request;
use JsonException;

/**
 * Class MainRouter
 * @package App\Components
 */
class MainRouter
{
    /**
     * @var mixed
     */
    private $routeUrlParameter;
    /**
     * @var mixed
     */
    private $routeCallback;


    /**
     * MainRouter constructor.
     * @param ParseArguments $parseArguments
     */
    public function __construct(ParseArguments $parseArguments)
    {
        $this->routeCallback = $parseArguments->getCallback();
        $this->routeUrlParameter = $parseArguments->getParameters();

    }

    /**
     * @return bool|mixed
     */
    public function isEqualUrlParamWithRouteParam()
    {
        $getUrl = (new Request())->url()->path() ?? '/';
        if (trim($this->routeUrlParameter, '/') === trim($getUrl, '/')) {
            return (new ExecuteRouter())->callUserFunc($this->routeCallback);
        }

        return $this->callFuncRouterDynamic();


    }

    /**
     * @return bool|mixed
     */
    private function callFuncRouterDynamic()
    {
        $isEqualRouterParam = new CompareUrlParameter($this->routeUrlParameter);
        return $isEqualRouterParam->callUserFunc($this->routeCallback);
    }

    /**
     * @param $name
     */
    public function name($name): void
    {
        RouterName::setName($name, $this->routeUrlParameter);
    }

    public function __destruct()
    {
        $result = $this->isEqualUrlParamWithRouteParam();
        try {
            (new Printable($result))->output();
        } catch (JsonException $e) {

            echo $e->getMessage();
        }
    }
}