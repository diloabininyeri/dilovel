<?php


namespace App\Providers;


class SessionProvider implements ProviderInterface
{

    public function register(): void
    {
        // TODO: Implement register() method.
    }

    public function boot(): void
    {
        session()->set('city','adana');
    }
}