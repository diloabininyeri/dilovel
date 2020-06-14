<?php


namespace App\Bootstrap;

/**
 * Class Application
 * @package App\Bootstrap
 */
class Application
{


    /**
     *
     */
    public static function run(): void
    {
        Bootstrap::loadProviders();
    }
}
