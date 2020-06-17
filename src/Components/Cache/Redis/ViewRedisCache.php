<?php


namespace App\Components\Cache\Redis;

use App\Interfaces\ViewCacheInterface;

/**
 * Class ViewRedisCache
 * @package App\Components\Cache\Redis
 */
class ViewRedisCache implements ViewCacheInterface
{
    /**
     * @var Redis
     */
    private Redis $redis;

    /**
     * ViewRedisCache constructor.
     */
    public function __construct()
    {
        $this->redis = Redis::connection();
    }

    /**
     * @param string $name
     * @return mixed|string
     */
    public function getCache(string $name)
    {
        return $this->redis->get($name);
    }

    /**
     * @param string $name
     * @param $value
     * @param $time
     * @return mixed
     */
    public function setCache(string $name, $value, $time)
    {
        return $this->redis->set($name, $value, 'ex', $time);
    }
}
