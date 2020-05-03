<?php


namespace App\Components\Shutdown;


use App\Components\Shutdown\Error\LastError;

/**
 * Class App
 * @package App\Components\Shutdown
 *
 */
class App extends AbstractShutdownRegister
{

    /**
     * @var array|string[]
     */
    protected array $register = [
        LastError::class
    ];
}