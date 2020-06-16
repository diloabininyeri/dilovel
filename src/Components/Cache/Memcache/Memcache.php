<?php


namespace App\Components\Cache\Memcache;

use App\Components\Traits\Singleton;
use Memcached;

/**
 * Class MemcacheClient
 * @package App\Components\Cache\Memcache
 * @mixin Memcached
 */
class Memcache
{
    use Singleton {
        getInstance as connection;
    }

    /**
     * @var Memcached
     */
    protected Memcached $memcache;


    /**
     * MemcacheClient constructor.
     */
    public function __construct()
    {
        $this->memcache = new Memcached();
        $this->memcache->addServer(config('memcache.host'), config('memcache.port'));
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->memcache->$name(...$arguments);
    }
}
