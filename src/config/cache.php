<?php


use App\Components\Cache\Memcache\ViewMemcached;

return [
    'view'=>'memcache',
    'clients'=>[
        'memcache'=> ViewMemcached::class
    ]
];
