<?php


namespace App\Components\Route;

use App\Components\Http\Request;

/**
 * Class CallControllerWithoutIoc
 * @package App\Components\Route
 */
class CallControllerWithoutIoc
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
        $this->request = $request;
    }

    /**
     * @return string
     */
    public function call()
    {
        $controller=$this->controller;
        return call_user_func([new $controller, $this->method], $this->request);
    }
}
