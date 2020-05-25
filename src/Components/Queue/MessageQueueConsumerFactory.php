<?php


namespace App\Components\Queue;

use Closure;
use ErrorException;

/**
 * Class MessageQueueConsumerFactory
 * @package App\Components\Queue
 */
class MessageQueueConsumerFactory
{

    /**
     * @var string
     */
    private string $queueName;

    /**
     * @var int
     */
    private int $microSleep;

    /**
     * @var MessageQueue
     */
    private MessageQueue  $queue;

    /**
     * MessageQueueConsumerFactory constructor.
     * @param string $queueName
     * @param int $microSleep
     */
    public function __construct(string $queueName, int $microSleep)
    {
        $this->queue = new MessageQueue($queueName);
        $this->queueName = $queueName;
        $this->microSleep = $microSleep;
    }


    /**
     * @param Closure $closure
     * @throws ErrorException
     */
    public function with(Closure $closure): void
    {
        $this->queue->setMicroSleep($this->microSleep);
        $this->queue->receiveCallback($this->queueName, $closure);
    }

    /**
     * @throws ErrorException
     */
    public function listen(): void
    {
        $this->queue->setMicroSleep($this->microSleep);
        $this->queue->receive($this->queueName);
    }
}
