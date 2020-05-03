<?php


namespace App\Components\Shutdown\Error;


use App\Interfaces\RegisterShutdownInterface;

/**
 * Class LastError
 * @package App\Components\Shutdown\Error
 */
class LastError implements RegisterShutdownInterface
{

    /** @noinspection ForgottenDebugOutputInspection */
    public function appOnShutdown(): void
    {
       $error=error_get_last();
       ini_set('error_log','src/logs/error.log');
       error_log($error['message'],$error['type']);
    }
}