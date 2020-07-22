<?php


namespace App\Components\Route;

use Closure;

/**
 * Class RouterGroup
 * @package App\Components\Route
 */
class RouterGroup
{

    /**
     * @var array
     */
    private array $namespaces;


    /**
     * @var Closure
     */
    private Closure $callback;

    /**
     * @param array $attribute
     * @return RouterGroup
     */
    public function setAttribute(array $attribute): RouterGroup
    {
        $this->namespaces = $attribute;
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
     * @param Closure $callback
     * @return RouterGroup
     */
    public function setCallback(Closure $callback): RouterGroup
    {
        $this->callback = $callback;
        return $this;
    }

    /**
     * @return Closure
     */
    public function getCallback(): Closure
    {
        return $this->callback;
    }
}
