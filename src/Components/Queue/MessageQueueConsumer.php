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
}
