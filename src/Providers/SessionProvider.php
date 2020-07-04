<?php


namespace App\Providers;

use App\Components\Lang\Lang;

class SessionProvider implements ProviderInterface
{
    public function register(): void
    {
        // TODO: Implement register() method.
    }

    public function boot(): void
    {
        if (!Lang::isExistSessionLanguage()) {
            preg_match_all('/[a-z]+/m', config('app.locale'), $matches, PREG_SET_ORDER);
            Lang::set($matches[0][0]);
        }
    }
}
