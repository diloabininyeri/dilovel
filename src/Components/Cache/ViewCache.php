<?php


namespace App\Components\Cache;

use App\Interfaces\ViewCacheInterface;

/**
 * Class ViewCache
 * @package App\Components\Cache
 */
class ViewCache
{
    /**
     * @var ViewCacheInterface
     */
    private ViewCacheInterface  $cacheObject;

    /**
     * ViewCache constructor.
     */
    public function __construct()
    {
        $cacheClient = config('viewcache.cache_with');
        $cacheClass = config("viewcache.clients.$cacheClient");
        $this->cacheObject = new $cacheClass();
    }
    /**
     * @return mixed
     */
    public function get()
    {
        return $this->cacheObject->getCache(url()->full());
    }

    /**
     * @return bool
     */
    public function exist(): bool
    {
        return !is_null($this->cacheObject->getCache(url()->full()));
    }

    /**
     * @param $renderedView
     * @param $time
     * @return mixed
     */
    public function set($renderedView, $time)
    {
        return $this->cacheObject->setCache(url()->full(), $renderedView, $time);
    }
}
