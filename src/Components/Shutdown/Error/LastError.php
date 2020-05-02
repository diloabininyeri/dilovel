<?php


namespace App\Components\Shutdown\Error;


use App\Interfaces\registerShutdownInterface;

class LastError implements registerShutdownInterface
{

    public function appOnShutdown(): void
    {
        // TODO: Implement appOnShutdown() method.
    }
}