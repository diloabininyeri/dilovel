<?php


namespace App\Components\Route;

use App\Components\Http\Request;
use ReflectionException;
use ReflectionMethod;

/**
 * Class CallController
 * @package App\Components\Route
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
     * @param null $namespace
     */
    public function __construct(string $controller, string $method, $request, $namespace=null)
    {
        $this->controller = $controller;
        $this->method = $method;
        $this->request = $request;
        if ($namespace) {
            $this->namespace.="$namespace\\";
        }
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
    private function isNotRuleRequest(): bool
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
        if (isset($reflection->getParameters()[0])) {
            return $reflection->getParameters()[0]->getClass()->getName();
        }
        return Request::class;
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
