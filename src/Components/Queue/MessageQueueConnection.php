<?php


namespace App\Components\Queue;

use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Class MessageQueueConnection
 * @package App\Components\Queue
 */
class MessageQueueConnection
{

    /**
     * @return AMQPStreamConnection
     */
    public static function get(): AMQPStreamConnection
    {
        return new AMQPStreamConnection(
            config('rabitmq.host'),
            config('rabitmq.port'),
            config('rabitmq.user'),
            config('rabitmq.password'),
        );
    }
}
