<?php


namespace App\Components\Cache;

use App\Components\Cache\Redis\Redis;
use App\Components\String\StrComponent;
use Closure;

/**
 * Class MainCache
 * @package App\Components\Cache
 */
class MainCache
{
    /**
     * @var Redis
     */
    private Redis $redis;

    /**
     * MainCache constructor.
     */
    public function __construct()
    {
        $this->redis = Redis::connection();
    }


    /**
     * @param string $name
     * @param Closure $closure
     * @param int $second
     * @return mixed
     */
    public function remember(string $name, Closure $closure, int $second = 120)
    {
        if ($this->redis->exists($name)) {
            return unserialize($this->redis->get($name), ['allowed_classes' => true]);
        }
        $data = $closure();
        $this->redis->setex($name, $second, serialize($data));
        return $data;
    }

    /**
     * @param string $key
     * @param null $default
     * @return string|null
     */
    public function get(string $key, $default=null): ?string
    {
        return $this->redis->get($key) ?? $default;
    }

    /**
     * @param string $key
     * @param $value
     * @return mixed
     */
    public function set(string $key, $value)
    {
        return $this->redis->set($key, $value);
    }


    /**
     * @param string $key
     * @param $value
     * @param int $time
     * @return int
     */
    public function setex(string $key, $value, $time=120): int
    {
        return $this->redis->setex($key, $time, $value);
    }

    /**
     * @param string $key
     * @return StrComponent|null
     */
    public function getString(string $key): ?StrComponent
    {
        return new StrComponent($this->redis->get($key)) ?? null;
    }
    /**
     * @param string $key
     * @return bool
     */
    public function exists(string $key):bool
    {
        return $this->redis->exists($key);
    }
}
