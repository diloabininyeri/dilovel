<?php


namespace App\Components\Routers;


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
     * CallControllerWithIoc constructor.
     * @param string $controller
     * @param string $method
     * @param $request
     */
    public function __construct(string $controller, string $method,$request)
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
        return $this->controller . '    ' . $this->method;
    }
}