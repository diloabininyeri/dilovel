<?php


namespace Bin\Components;


use App\Components\Reflection\ProtectedProperty;
use Bin\Console;
use ReflectionException;

/**
 * Class Command
 * @package Bin\Components
 */
class Command
{

    /**
     * @return mixed
     * @throws ReflectionException
     */
    public static function list()
    {
        return (new ProtectedProperty())
            ->setObject(new Console())
            ->setProperty('commands')
            ->getValue();
    }
}