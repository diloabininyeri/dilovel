<?php


namespace Bin\Components\Process;

use App\Interfaces\ProcessForkInterface;

/**
 * Class Async
 * @package Bin\Components\Process
 */
class Async
{

    /**
     * @param ProcessForkInterface $processFork
     */
    public static function call(ProcessForkInterface $processFork):void
    {
        $process = new Process($processFork);
        $process->runOneByOneClosure();
    }
}
