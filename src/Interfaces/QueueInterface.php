<?php


namespace App\Interfaces;

use App\Application\Listeners\Exceptions\Exception;

/**
 * Interface QueueInterface
 * @package App\Interfaces
 */
interface QueueInterface
{
    /**
     * @return mixed
     */
    public function handle();

    /**
     * @param Exception $object
     */
    public function failed(Exception $object):void ;
}
