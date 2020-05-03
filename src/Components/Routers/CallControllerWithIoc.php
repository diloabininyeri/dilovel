<?php


namespace App\Components\Routers;

use App\Components\Http\Request;

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
        return $this->controller . '    ' . $this->method.$this->request;
    }
}
