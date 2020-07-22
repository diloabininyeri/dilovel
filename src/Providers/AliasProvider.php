<?php


namespace App\Providers;

use App\Components\Cache;
use App\Components\Container\App;
use App\Components\Route\Route;
use App\Components\Http\Session;

class AliasProvider implements ProviderInterface
{
    public function register(): void
    {
        // TODO: Implement register() method.
    }

    public function boot(): void
    {
        class_alias(Cache::class, 'Cache');
        class_alias(Route::class, 'Route');
        class_alias(App::class, 'App');
        class_alias(Session::class, 'Session');
    }
}
