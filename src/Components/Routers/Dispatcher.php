<?php


namespace App\Components\Routers;


use App\Application\Middleware;
use App\Components\Http\Request;

/**
 * Class Dispatcher
 * @package App\Components\Routers
 */
class Dispatcher
{

    /**
     * @param $middleware
     * @return Middleware
     */
    private function callMiddleware($middleware): Middleware
    {

        $middleware=new Middleware(...$middleware);
        return $middleware->call(new Request());
    }
    /**
     * @param RouterObject $routerObject
     * @return mixed
     */
    public function route(RouterObject $routerObject)
    {


        if(!empty($routerObject->getMiddleware())) {
            $middleware = $this->callMiddleware($routerObject->getMiddleware());
            if (!$middleware->isInstanceOfRequest()) {
                return  $middleware->getResponse();
            }
        }

        if($routerObject->isCallableSecondParameter()) {
            return call_user_func($routerObject->getSecondParameter(), $middleware->getResponse());
        }
        return  $routerObject->getSecondParameter();

    }
}