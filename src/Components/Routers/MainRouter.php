<?php

namespace App\Components\Routers;


use Closure;


/**
 * Class MainRouter
 * @package App\Components
 */
class MainRouter
{
    /**
     * @var array
     */
    private array $namespaces;

    /**
     * @var array $authorize
     */
    private ?array $authorize=[];


    /**
     * @var string $name
     */
    private ?string $name=null;

    /**
     * @var RouterGroup $group
     */
    private ?RouterGroup $group = null;

    /**
     * @var string $dynamicUrl
     */
    private string $dynamicUrl;

    /**
     * @var $secondParameter
     */
    private $secondParameter;

    /**
     * @var array
     */
    private ?array $middleware=[];

    /**
     * @param mixed $name
     * @return MainRouter
     */
    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @param array $namespaces
     * @return MainRouter
     */
    public function namespaces(array $namespaces): MainRouter
    {
        $this->namespaces = $namespaces;
        return $this;
    }

    /**
     * @return array
     */
    public function getNamespaces(): array
    {
        return $this->namespaces;
    }

    /**
     * @param $namespaces
     * @param Closure $callback
     * @return void
     */
    public function group($namespaces, Closure $callback): void
    {
        $this->group = (new RouterGroup())
            ->setAttribute($namespaces)
            ->setCallback($callback);
    }

    /**
     * @return RouterGroup
     */
    public function getGroup(): RouterGroup
    {
        return $this->group;
    }

    /**
     * @param mixed $dynamicUrl
     * @return MainRouter
     */
    public function setDynamicUrl($dynamicUrl): self
    {
        $this->dynamicUrl = $dynamicUrl;
        return $this;
    }

    /**
     * @param mixed $secondParameter
     * @return MainRouter
     */
    public function setSecondParameter($secondParameter): self
    {
        $this->secondParameter = $secondParameter;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSecondParameter()
    {
        return $this->secondParameter;
    }

    /**
     * @param mixed $middleware
     * @return MainRouter
     */
    public function middleware(...$middleware): self
    {
        $this->middleware = $middleware;
        return $this;
    }

    /**
     * @return array
     */
    public function getMiddleware(): array
    {
        return $this->middleware;
    }

    /**
     * @return string
     */
    public function getDynamicUrl(): string
    {
        return trim($this->dynamicUrl, '/');
    }


    /**
     * @return string
     */
    public function getUrlPath(): string
    {
        $url = strtok($_SERVER['REQUEST_URI'], '?');
        return trim($url, '/');
    }

    public function __destruct()
    {
        RouterStorage::add($this);
    }

    /**
     * @param array $authorize
     * @return MainRouter
     */
    public function authorize(array $authorize):self
    {
        $this->authorize = $authorize;
        return $this;
    }

    /**
     * @return array
     */
    public function getAuthorize(): array
    {
        return $this->authorize;
    }

}