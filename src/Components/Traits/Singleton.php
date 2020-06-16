<?php


namespace App\Components\Traits;

/**
 * Trait Singleton
 * @package App\Components\Traits
 */
trait Singleton
{
    /**
     * @var Singleton|null $this |null
     */
    private static ?self $singleton=null;

    /**
     * @return self
     */
    public static function getInstance(): self
    {
        if (!self::$singleton) {
            self::$singleton = new self();
        }
        return self::$singleton;
    }
}
