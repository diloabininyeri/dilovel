<?php


namespace App\Components\Routers;

use App\Components\Http\Request;
use App\Components\Reflection\IocContainer;

/**
 * Class CallControllerWithIoc
 * @package App\Components\Routers
 */
class CallControllerWithIoc
{

    /**
     * @var string
     */
    private string $controller;

    /**
     * @var string
     */
    private string $method;
    /**
     * @var Request
     */
    private Request $request;

    /**
     * CallControllerWithIoc constructor.
     * @param string $controller
     * @param string $method
     * @param Request $request
     */
    public function __construct(string $controller, string $method, Request $request)
    {
        $this->controller = $controller;
        $this->method = $method;
        $this->request=$request;
    }

    /**
     * @return string
     */
    public function call()
    {
        $ioc=new IocContainer($this->request);
        return $ioc->onError(function ($error) {
            print_r($error);
        })->onSuccess(fn ($req) =>call_user_func([new $this->controller,$this->method], $req))
           ->setController($this->controller)
           ->setMethod($this->method)
           ->call();
    }
}
