<?php


namespace App\interfaces;

/**
 * Interface Session
 * @package App\interfaces
 */
interface Session
{

    /**
     * @param $name
     * @param null $default
     * @return string|null
     */
    public function get($name, $default = null): ?string;

    /**
     * @param $name
     * @return bool
     */
    public function exists($name):bool;
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
    public function delete($name):bool;
}