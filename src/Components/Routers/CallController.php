<?php


namespace App\Components\Routers;

use App\Components\Http\Request;

/**
 * Class CallController
 * @package App\Components\Routers
 */
class CallController
{
    /**
     * @var string
     */
    private string $namespace = 'App\\Application\\Controllers\\';

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
     * CallController constructor.
     * @param string $controller
     * @param string $method
     * @param  $request
     */
    public function __construct(string $controller, string $method, $request)
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
        if ($this->getRequestMethod() === 'POST') {
            return (new CallControllerWithIoc($this->createClassNameController(), $this->method, $this->request))->call();
        }
        return (new CallControllerWithoutIoc($this->createClassNameController(), $this->method, $this->request))->call();
    }

    /**
     * @return string
     */
    private function createClassNameController(): string
    {
        return sprintf('%s%s', $this->namespace, trim($this->controller, '\\'));
    }

    /**
     * @return string
     *
     */
    private function getRequestMethod(): string
    {
        return   $_SERVER['REQUEST_METHOD'];
    }
}
