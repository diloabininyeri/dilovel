<?php


namespace App\Components\Routers;

/**
 * Class GenerateRouterGroup
 * @package App\Components\Routers
 */
class GenerateRouterGroup
{
    /**
     * @var mixed|string|null
     */
    private ?string  $namespaceGroupName = null;

    /**
     * @var array|mixed
     */
    private array $middleware;

    /**
     * @var mixed|string
     */
    private string  $namespace;

    private ?string $prefix=null;
    /**
     * @var array|MainRouter[]
     */
    private array  $routers;


    /**
     * GenerateRouterGroup constructor.
     * @param array $namespaceAttribute
     * @param array $routers
     */
    public function __construct(array $namespaceAttribute, array $routers)
    {
        $this->namespaceGroupName = $namespaceAttribute['name'] ?? null;
        $this->middleware = $namespaceAttribute['middleware'] ?? [];
        $this->namespace = $namespaceAttribute['namespace'];
        $this->routers = $routers;
        $this->prefix=$namespaceAttribute['prefix'] ??null;
    }

    /**
     * @return bool
     */
    public function isCanPassMiddleware(): bool
    {
        $this->middleware;
        return true;
    }


    /**
     * @return $this
     */
    public function updateNamespace(): self
    {
        foreach ($this->routers as $router) {
            $router->namespace($this->namespace);
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function updateName(): self
    {
        foreach ($this->routers as $router) {
            $isUpdatedRouter=false;
            if ($this->namespaceGroupName!==null && $router->getName()) {
                $newName=$this->namespaceGroupName.'.'.$router->getName();
                RouterName::update($router->getName(), $newName);
                $isUpdatedRouter=true;
                $router->name($newName);
            }
            if ($this->prefix !== null) {
                if ($isUpdatedRouter===true) {
                    RouterName::addBeginningDynamicUrl($newName, $this->prefix);
                } else {
                    RouterName::addBeginningDynamicUrl($router->getName(), $this->prefix);
                }
                $router->setDynamicUrl(trim($this->prefix, '/').'/'.trim($router->getDynamicUrl(), '/'));
            }
        }
        return $this;
    }
}
