<?php


namespace Bin\Components\Process;


/**
 * Class Async
 * @package Bin\Components\Process
 */
class Async
{

    /**
     *
     */
    public function callMultiProcess():void
    {

        $process = new Process(new ExampleProcess());
        $process->executeParallelClosure();

    }

}