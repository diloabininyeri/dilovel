<?php


namespace App\Components\Queue;

use Closure;
use ErrorException;
use Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class MessageQueue
 * @package App\Components\Queue
 */
class MessageQueue
{
    /**
     * @var AMQPStreamConnection
     */
    private AMQPStreamConnection $connection;

    /**
     * @var AMQPChannel
     */
    private AMQPChannel $channel;

    /**
     * @var array|null
     */
    private ?array $status;

    /**
     * @var int
     */
    private int  $microSleep = 0;

    /**
     * MessageQueue constructor.
     * @param string $queueName
     */
    public function __construct($queueName = 'default')
    {
        $this->connection = MessageQueueConnection::get();

        $this->channel = $this->connection->channel();

        $this->status = $this->channel->queue_declare(
            $queueName,
            false,
            true,
            false,
            false
        );
    }

    /**
     * @param $queueName
     * @throws ErrorException
     */
    public function receive($queueName): void
    {
        $callback = static function ($msg) {
            echo "working operation : " . json_encode($msg->body, JSON_THROW_ON_ERROR) . PHP_EOL;
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        };

        $this->channel->basic_qos(null, 1, null);
        $this->channel->basic_consume($queueName, '', false, false, false, false, $callback);
        $this->consumerFromCli();
    }


    /**
     * @throws ErrorException
     */
    private function consumerFromCli(): void
    {
        echo "waiting..." . PHP_EOL;
        while (count($this->channel->callbacks)) {
            $this->channel->wait();
            usleep($this->microSleep);
        }
    }

    /**
     * @param $queueName
     * @param Closure $closure
     * @throws ErrorException
     */
    public function receiveCallback($queueName, Closure $closure): void
    {
        $callback = static function ($msg) use ($closure) {
            $closure($msg->body);
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        };

        $this->channel->basic_qos(null, 1, null);
        $this->channel->basic_consume($queueName, '', false, false, false, false, $callback);
        $this->consumerFromCli();
    }

    /**
     * @param $msgStr
     * @param $queueName
     */
    public function addToQueue($msgStr, $queueName): void
    {
        $this->channel->basic_publish(new AMQPMessage($msgStr), '', $queueName);
    }

    /**
     * @throws Exception
     */
    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }

    /**
     * @return array|null
     */
    public function getStatus(): ?array
    {
        [$queue, $message_count, $listener_count] = $this->status;
        return compact('queue', 'message_count', 'listener_count');
    }

    /**
     * @param int $microSleep
     * @return MessageQueue
     */
    public function setMicroSleep(int $microSleep): MessageQueue
    {
        $this->microSleep = $microSleep;
        return $this;
    }
}
