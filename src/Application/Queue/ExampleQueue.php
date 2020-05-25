<?php


namespace App\Application\Queue;

use App\Application\Listeners\Exceptions\Exception;
use App\Interfaces\QueueInterface;

/**
 * Class ExampleQueue
 * @package App\Application\Queue
 */
class ExampleQueue implements QueueInterface
{
    /**
     * @var string
     */
    private string $name;

    /**
     * ExampleQueue constructor.
     * @param string $name
     */
    public function __construct(string  $name)
    {
        $this->name = $name;
    }


    /**
     * @return mixed|string
     */
    public function handle()
    {
        return  $this->name;
    }

    /**
     * @param Exception $object
     */
    public function failed(Exception $object):void
    {
        // TODO: Implement failed() method.
    }
}
