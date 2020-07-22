<?php

namespace App\Components\Route;

use Closure;

/**
 * Class MainRouter
 * @package App\Components
 */
class MainRouter
{
    /**
     * @var string $method
     */
    private ?string $method=null;
    /**
     * @var string
     */
    private ?string $namespace=null;

    /**
     * @var array $authorize
     */
    private ?array $authorize = [];


    /**
     * @var string $name
     */
    private ?string $name = null;

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
    private ?array $middleware = [];

    private ?string $view=null;

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
     * @param string $namespaces
     * @return $this
     *
     */
    public function namespace(?string $namespaces): MainRouter
    {
        $this->namespace = $namespaces;
        return $this;
    }

    /**
     * @return string
     */
    public function getNamespace(): ?string
    {
        return $this->namespace;
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
    public function setSecondParameter($secondParameter=null): self
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
    public function getUrlPath(): ?string
    {
        if (PHP_SAPI === "cli") {
            return null;
        }
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
    public function authorize(array $authorize): self
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

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return MainRouter
     */
    public function setMethod(string $method): MainRouter
    {
        $this->method =strtoupper($method);
        return $this;
    }

    /**
     * @param string $view
     * @return $this
     */
    public function view(string $view):self
    {
        $this->view=$view;
        return $this;
    }
    /**
     * @return string|null
     */
    public function getView(): ?string
    {
        return $this->view;
    }
}
