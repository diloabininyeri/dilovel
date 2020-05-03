<?php


namespace App\Components\Shutdown;


use App\Components\Shutdown\Error\LastError;

/**
 * Class Shutdown
 * @package App\Components\Shutdown
 */
class Shutdown extends AbstractShutdownRegister
{

    /**
     * @var array|string[]
     */
    protected array $register = [
        LastError::class
    ];
}