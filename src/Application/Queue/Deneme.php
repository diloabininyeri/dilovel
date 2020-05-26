<?php


namespace App\Application\Queue;


use Exception;
use App\Interfaces\QueueInterface;

/**
 * Class ExampleQueue
 * @package App\Application\Queue
 */
class Deneme implements QueueInterface
{


    /**
     * @return mixed|string
     */
    public function handle()
    {
        sleep(10);
        return  'foo something bar'.random_int(1,100);
    }

    /**
     * @param Exception $object
     */
    public function failed(Exception $object):void
    {
        // TODO: Implement failed() method.
    }
}
