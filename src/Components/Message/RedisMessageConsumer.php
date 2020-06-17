<?php


namespace App\Components\Message;

use Closure;
use Predis\Client;

class RedisMessageConsumer
{
    /**
     * @param string $channel
     * @param Closure $closure
     * @noinspection NullPointerExceptionInspection
     * @noinspection PhpUndefinedFieldInspection
     */
    public static function subscribe(string $channel, Closure $closure):void
    {
        $client = new Client(get_config_array('redis') + array('read_write_timeout' => 0));
        $pubSubLoop = $client->pubSubLoop();
        $pubSubLoop->subscribe($channel);

        foreach ($pubSubLoop as $message) {
            if ($message->kind==='message') {
                $closure($message->payload);
            }
        }

        unset($pubSubLoop);
        $version = redis_version($client->info());
        echo "Goodbye from Redis $version!", PHP_EOL;
    }
}
