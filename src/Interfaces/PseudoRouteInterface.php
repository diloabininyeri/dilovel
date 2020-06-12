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
    public function get($dynamicUrl, $callback): self;

    /**
     * @param $dynamicUrl
     * @param $callback
     * @return $this
     */
    public function post($dynamicUrl, $callback): self;

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

    /**
     * @param callable $callback
     * @return $this
     */
    public function authorize(callable $callback):self ;
}
