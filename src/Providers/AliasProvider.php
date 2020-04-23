<?php


namespace App\Providers;


class AliasProvider implements ProviderInterface
{


    public function register(): void
    {
        // TODO: Implement register() method.
    }

    public function boot(): void
    {
        class_alias('\App\Components\Cache', 'Cache');
        class_alias('\App\Components\Router', 'Router');
    }
}