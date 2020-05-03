<?php


namespace App\Providers;

/**
 * Interface ProviderInterface
 * @package App\Providers
 */
interface ProviderInterface
{

    /**
     *
     */
    public function register(): void;

    /**
     *
     */
    public function boot(): void;
}
