<?php


namespace App\Providers;

use App\Application\Controllers\MyContainerTest;
use App\Components\View\Master;

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
    }
}
