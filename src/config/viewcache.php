<?php


use App\Components\Cache\Memcache\ViewMemcached;
use App\Components\Cache\Redis\ViewRedisCache;

return [
    'cache_with'=>'redis',
    'clients'=>[
        'memcache'=> ViewMemcached::class,
        'redis'=> ViewRedisCache::class
    ]
];
