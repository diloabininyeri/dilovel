<?php


namespace App\Components\Reflection;

use ReflectionObject;

/**
 * Class ObjectBeautifier
 * @package App\Components\Reflection
 */
class CodeBeautifier
{
    /**
     * @param object $object
     * @return bool|string
     */
    public static function fromObject(object $object)
    {
        return highlight_file((new ReflectionObject($object))->getFileName(), true);
    }

    /**
     * @param string $path
     * @return string
     */
    public static function fromPhpFile(string $path):string
    {
        return highlight_file($path, true);
    }

    /**
     * @param string $code
     * @return string
     */
    public static function fromPhpCode(string $code):string
    {
        return highlight_string($code, true);
    }
}
