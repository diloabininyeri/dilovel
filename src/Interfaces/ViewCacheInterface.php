<?php


namespace App\Interfaces;

/**
 * Interface CacheViewInterface
 * @package App\Interfaces
 */
interface ViewCacheInterface
{

    /**
     * @param string $name
     * @return mixed
     */
    public function getCache(string $name);

    /**
     * @param string $name
     * @param $value
     * @param $time
     * @return mixed
     */
    public function setCache(string $name, $value, $time);
}
