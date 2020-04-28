<?php


namespace App\Components\Routers;


use App\Components\Http\Request;

/**
 * Class Dispatcher
 * @package App\Components\Routers
 */
class Dispatcher
{

    /**
     * @param RouterObject $routerObject
     * @return mixed
     */
    public function route(RouterObject $routerObject)
    {
        if($routerObject->isCallableSecondParameter()) {
            return call_user_func($routerObject->getSecondParameter(), new Request());
        }
        return  $routerObject->getSecondParameter();

    }
}