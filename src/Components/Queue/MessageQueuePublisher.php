<?php


namespace App\Components\Queue;

use Exception;

/**
 * Class MessageQueuePublisher
 * @package App\Components\Queue
 */
class MessageQueuePublisher
{


    /**
     * @param $queueName
     * @param $message
     */
    public static function add(string $queueName, string $message): void
    {
        $queue = new MessageQueue($queueName);
        $queue->addToQueue($message, $queueName);
    }
}
