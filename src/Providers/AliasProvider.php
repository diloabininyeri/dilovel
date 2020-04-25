<?php


namespace App\Providers;


use App\Components\Cache;
use App\Components\Container\App;
use App\Components\Routers\Router;
use App\Http\Session;

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
        class_alias(App::class, 'App');
        class_alias(Session::class, 'Session');
    }
}