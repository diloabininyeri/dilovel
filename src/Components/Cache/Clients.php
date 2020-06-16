<?php


namespace App\Components\Cache;

use App\Components\Cache\Memcache\Memcache;
use App\Components\Cache\Redis\Redis;

class Clients
{
    public const CLASSES=[

        'redis'=>Redis::class,
        'memcache'=>Memcache::class
    ];
}
