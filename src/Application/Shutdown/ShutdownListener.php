<?php


namespace App\Application\Shutdown;

use App\Interfaces\RegisterShutdownInterface;

class ShutdownListener implements RegisterShutdownInterface
{
    public function appOnShutdown(): void
    {

        // when application end  kernel call this method
    }
}
