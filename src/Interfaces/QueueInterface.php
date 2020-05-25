<?php


namespace App\Interfaces;

use Exception;

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
