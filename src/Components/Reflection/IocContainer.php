<?php


namespace App\Components\Reflection;


use Closure;

/**
 * Class IocContainer
 * @package App\Components\Reflection
 */
class IocContainer
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
     * @var array
     */
    private array $requestErrors;

    /**
     * @var Closure
     */
    private Closure $onSuccessCallback;

    /**
     * @var Closure
     */
    private Closure $onErrorCallback;

    /**
     * IocContainer constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param string $controller
     * @return IocContainer
     */
    public function setController(string $controller): IocContainer
    {
        $this->controller = $controller;
        return $this;
    }

    /**
     * @param string $method
     * @return IocContainer
     */
    public function setMethod(string $method): IocContainer
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    private function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    private function getController(): string
    {
        return $this->controller;
    }

    /**
     * @param callable $callback
     * @return $this
     */
    public function onSuccess(callable $callback): self
    {
        $this->onSuccessCallback = $callback;
        return $this;
    }

    /**
     * @param callable $callback
     * @return $this
     */
    public function onError(callable $callback): self
    {
        $this->onErrorCallback = $callback;
        return $this;

    }


    /**
     *
     */
    public function call()
    {

    }

}