<?php


namespace Bin\Commands;

use App\Components\Cache\Redis\Redis;
use Bin\Components\CommandInterface;

class RedisMessageConsumerCommand implements CommandInterface
{
    protected string $description = 'redis message consumer command';

    public function handle(?array $parameters): void
    {
        $chanel=$parameters[0] ?? 'default';
        Redis::subscribe($chanel, static function ($param) {
            print_r($param);
        });
    }
}
