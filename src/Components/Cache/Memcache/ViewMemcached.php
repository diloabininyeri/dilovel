<?php


namespace App\Components\Cache\Memcache;

use App\Interfaces\ViewCacheInterface;

/**
 * Class ViewMemcached
 * @package App\Components\Cache\Memcache
 */
class ViewMemcached extends Memcache implements ViewCacheInterface
{


    /**
     * @param string $name
     * @return mixed
     */
    public function getCache(string $name)
    {
        return $this->get($name);
    }

    /**
     * @param string $name
     * @param $value
     * @param $time
     * @return bool|mixed
     */
    public function setCache(string $name, $value, $time)
    {
        return $this->set($name, $value, $time);
    }
}
