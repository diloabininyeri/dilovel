<?php


namespace App\Components\Queue;

use Closure;
use ErrorException;

/**
 * Class MessageQueueConsumer
 * @package App\Components\Queue
 */
class MessageQueueConsumer
{
    /**
     * @param string $queueName
     * @param int $microSleep
     * @return MessageQueueConsumerFactory
     */
    public static function run(string $queueName, $microSleep=10000): MessageQueueConsumerFactory
    {
        return new MessageQueueConsumerFactory($queueName, $microSleep);
    }

    /**
     * @param string $queueName
     * @param int|null $sleepTime
     * @throws ErrorException
     */
    public static function listen(string $queueName, ?int $sleepTime=null): void
    {
        (new MessageQueueConsumerFactory($queueName, $sleepTime))->listen();
    }

    /**
     * @param string $name
     * @param Closure $closure
     * @param $microSleep
     * @throws ErrorException
     */
    public static function listenWithCallback(string $name, Closure $closure, $microSleep): void
    {
        (new MessageQueueConsumerFactory($name, $microSleep))->with($closure);
    }
}
