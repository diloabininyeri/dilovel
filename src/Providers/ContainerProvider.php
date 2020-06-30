<?php


namespace App\Providers;

use App\Application\Controllers\MyContainerTest;
use App\Components\View\Master;
use Carbon\Carbon;

/**
 * Class ContainerProvider
 * @package App\Providers
 */
class ContainerProvider implements ProviderInterface
{

    /**
     *
     */
    public function register(): void
    {
        app()->register('deneme', static function () {
            return new MyContainerTest();
        });
    }

    /**
     *
     */
    public function boot(): void
    {
        Carbon::setLocale(config('app.locale'));
    }
}
