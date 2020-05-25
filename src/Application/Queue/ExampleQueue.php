<?php


namespace App\Application\Queue;

use Exception;
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
        sleep(10);
        return  $this->name;
    }

    /**
     * @param Exception $exception
     */
    public function failed(Exception $exception):void
    {
        // TODO: Implement failed() method.
    }
}
