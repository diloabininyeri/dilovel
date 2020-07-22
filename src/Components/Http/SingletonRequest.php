<?php


namespace App\Components\Http;

/**
 * Class SingletonRequest
 * @package App\Components\Http
 */
class SingletonRequest
{
    /**
     * @return Request
     */
    public static function get(): Request
    {
        return Request::getInstance();
    }
}
