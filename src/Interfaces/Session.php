<?php


namespace App\Interfaces;

/**
 * Interface Session
 * @package App\interfaces
 */
interface Session
{

    /**
     * @param $name
     * @param null $default
     * @return string|null|array|object|mixed
     */
    public function get($name, $default = null);

    /**
     * @param $name
     * @return bool
     */
    public function exists($name): bool;

    /**
     * @param string $name
     * @param $value
     * @return bool
     */
    public function set(string $name, $value): bool;


    /**
     * @param $name
     * @return bool
     */
    public function delete($name): bool;


    /**
     * @param $name
     * @param $item
     * @return array
     */
    public function push($name, $item): array;


    /**
     * @return bool
     */
    public function flushAll(): bool;


    /**
     * @return array
     */
    public function all():array ;
}
