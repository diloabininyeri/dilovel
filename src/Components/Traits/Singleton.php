<?php


namespace App\Components\Traits;

/**
 * Trait Singleton
 * @package App\Components\Traits
 */
trait Singleton
{
    /**
     * @var object
     */
    private static ?object $singleton=null;

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        if (!self::$singleton) {
            self::$singleton = new self();
        }
        return self::$singleton;
    }
}