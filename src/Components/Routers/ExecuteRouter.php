<?php


namespace App\Components\Routers;


use App\Components\Http\Request;

/**
 * Class ExecuteRouter
 * @package App\Components
 */
class ExecuteRouter
{
    /**
     * @param $callback
     * @param null $namespace
     * @return mixed
     */
    public function callUserFunc($callback,$namespace=null)
    {
        ++NotFound::$isNotFound;
        if (is_callable($callback)) {
            return call_user_func_array($callback, $this->getUrlParametersFromUrl());
        }

        return $this->callController($callback,$namespace);

    }

    /**
     * @param $string
     * @param null $namespace
     * @return mixed
     */
    private function callController($string,$namespace=null)
    {
        $parseString=$this->parseString($string);
        $controller=$parseString['controller'];
        $method=$parseString['method'];
        $callableClassName=$this->createControllerClassName($controller,$namespace);
        $controller=new $callableClassName();

        return $controller->$method(new Request());
    }

    /**
     * @param $controller
     * @param null $namespace
     * @return string
     */
    private function createControllerClassName($controller, $namespace=null): string
    {
        if($namespace===null) {
            return "\\App\\app\\Controllers\\$controller";
        }
        return "\\App\\Controllers\\Payment\\$controller";
    }
    /**
     * @param $string
     * @return array
     */
    private function parseString($string): array
    {
        $explode= explode('@',$string);
        return[
            'controller'=>$explode[0],
            'method'=>$explode[1]
        ];
    }

    /**
     * @return array
     */
    public function getUrlParametersFromUrl(): array
    {
        return array_filter(explode('/', (new Request())->url()->path()));
    }
}