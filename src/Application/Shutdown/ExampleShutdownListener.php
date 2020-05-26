<?php


namespace App\Application\Shutdown;

use App\Interfaces\RegisterShutdownInterface;

class ExampleShutdownListener implements RegisterShutdownInterface
{
    public function appOnShutdown(): void
    {
        //
    }
}
