<?php


namespace App\Macro;


use Closure;

/**
 * Class ModelMacro
 * @package App\Macro
 */
class ModelMacro
{

    /**
     * @var array
     */
    public static array  $macro = [];

    /**
     * @param $methodName
     * @param Closure $closure
     */
    public static function addMethod($methodName, Closure $closure): void
    {
        self::$macro[$methodName] = $closure;
    }

    /**
     * @param $methodName
     * @return mixed
     */
    public static function getMethod($methodName)
    {
        return self::$macro[$methodName];
    }
}