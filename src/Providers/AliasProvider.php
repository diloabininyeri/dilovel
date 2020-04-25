<?php


namespace App\Providers;


use App\Components\Cache;
use App\Components\Routers\Router;

class AliasProvider implements ProviderInterface
{


    public function register(): void
    {
        // TODO: Implement register() method.
    }

    public function boot(): void
    {
        class_alias(Cache::class, 'Cache');
        class_alias(Router::class, 'Router');
    }
}