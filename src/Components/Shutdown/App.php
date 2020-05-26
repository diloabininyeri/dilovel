<?php


namespace App\Components\Shutdown;

use App\Application\Shutdown\ShutdownListener;

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

        ShutdownListener::class
    ];

    /**
     * @var array|string[] $dynamicRegister
     */
    protected static array $dynamicRegister=[];
}
