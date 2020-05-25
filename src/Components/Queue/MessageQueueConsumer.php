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
     * @param $queueName
     * @param $microSleep
     * @throws ErrorException
     */
    public static function listen($queueName, $microSleep=1000000): void
    {
        $queue = new MessageQueue($queueName);
        $queue->setMicroSleep($microSleep);
        $queue->receive($queueName);
    }

    /**
     * @param $queueName
     * @param Closure $closure
     * @param int $microSleep
     * @throws ErrorException
     */
    public static function listenWithCallback($queueName, Closure $closure, $microSleep=1000000):void
    {
        $queue = new MessageQueue($queueName);
        $queue->setMicroSleep($microSleep);
        $queue->receiveCallback($queueName, $closure);
    }
}
