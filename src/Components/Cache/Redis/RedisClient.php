<?php


namespace App\Components\Cache\Redis;

/**
 * Class RedisClient
 * @package App\Components\Cache\Redis
 */
class RedisClient
{
    /**
     * @return Redis
     */
    public static function get(): Redis
    {
        return new Redis();
    }
}
