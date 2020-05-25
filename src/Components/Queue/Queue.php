<?php


namespace App\Components\Queue;

use App\Interfaces\QueueInterface;
use Closure;
use ErrorException;

/**
 * Class Queue
 * @package App\Components\Queue
 */
class Queue
{

    /**
     * @var string
     */
    private string $name;

    /**
     * Queue constructor.
     * @param string $name
     */
    public function __construct(string $name='default')
    {
        $this->name = $name;
    }

    /**
     * @param $message
     */
    public function add(QueueInterface $message): void
    {
        MessageQueuePublisher::add($this->name, serialize($message));
    }

    /**
     * @param null $microSleep
     * @throws ErrorException
     */
    public function listen($microSleep=null):void
    {
        MessageQueueConsumer::listen($this->name, $microSleep);
    }


    /**
     * @param Closure $closure
     * @param $microSleep
     * @throws ErrorException
     */
    public function listenWithClosure(Closure $closure, $microSleep):void
    {
        MessageQueueConsumer::listenWithCallback($this->name, $closure, $microSleep);
    }
}
