<?php


namespace App\Interfaces;

/**
 * Interface PseudoRouteInterface
 * @package App\Interfaces
 */
interface PseudoRouteInterface
{

    /**
     * @param $dynamicUrl
     * @param $callback
     * @return $this
     */
    public function get($dynamicUrl, $callback=null): self;

    /**
     * @param $dynamicUrl
     * @param $callback
     * @return $this
     */
    public function post($dynamicUrl, $callback=null): self;

    /**
     * @param mixed ...$middleware
     * @return $this
     */
    public function middleware(...$middleware): self;

    /**
     * @param string $name
     * @return $this
     */
    public function name(string $name): self;

    public function view(string $view):self ;

    /**
     * @param callable $callback
     * @return $this
     */
    public function authorize(callable $callback):self ;


    /**
     * @param string $namespace
     * @return $this
     */
    public function namespace(string $namespace):self ;
}
