<?php


namespace App\Components\Routers;

use App\Components\Http\Request;
use ReflectionException;
use ReflectionMethod;

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
     * @throws ReflectionException
     */
    private function setRequestClass(): void
    {
        if (!$this->isNotRuleRequest()) {
            $request = $this->getRequestClass();
            $this->request = new $request();
        }
    }
    /**
     * @return string
     * @throws ReflectionException
     */
    public function call()
    {

        $this->setRequestClass();

        if ($this->getRequestMethod() === 'POST') {
            return (new CallControllerWithIoc($this->createClassNameController(), $this->method, $this->request))->call();
        }

        return (new CallControllerWithoutIoc($this->createClassNameController(), $this->method, $this->request))->call();
    }

    /**
     * compare inject class equal is Request class not RuleRequestClass
     * @return bool
     * @throws ReflectionException
     *
     */
    private function isNotRuleRequest()
    {
        return get_class($this->request) === $this->getRequestClass();
    }

    /**
     * @return string
     * @throws ReflectionException
     */
    private function getRequestClass(): string
    {
        $reflection = new ReflectionMethod($this->createClassNameController(), $this->method);
        return $reflection->getParameters()[0]->getClass()->getName();
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
        return $_SERVER['REQUEST_METHOD'];
    }
}
