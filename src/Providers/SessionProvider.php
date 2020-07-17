<?php


namespace App\Providers;

use App\Components\Lang\Lang;
use Carbon\Carbon;

class SessionProvider implements ProviderInterface
{
    public function register(): void
    {
        // TODO: Implement register() method.
    }

    public function boot(): void
    {
        if (!Lang::isExistSessionLanguage()) {
            Carbon::setLocale($config=config('app.locale'));
            preg_match_all('/[a-z]+/m', $config, $matches, PREG_SET_ORDER);
            Lang::set($matches[0][0]);
        }
    }
}
