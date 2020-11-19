<?php


namespace App\Components\Cache\Redis;

use Closure;

/**
 * Class Event
 * @package App\components\Redis
 */
class Event
{


    /**
     * @param string $data
     * @param string $channel
     * @return bool
     */
    public static function publish(string $data, string $channel='default'):bool
    {
        return Redis::connection()->publish($channel,$data);
    }

    /**
     * @param Closure $closure
     * @param string $channel
     */
    public static function subscribe(Closure $closure, string $channel='default'):void
    {
        Redis::subscribe($channel, $closure);
    }
}
