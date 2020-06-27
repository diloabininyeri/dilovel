<?php


namespace App\Providers;

use App\Components\View\Master;

class MasterPageProvider implements ProviderInterface
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Master::page('header', function () {
            return ['name'=>'dılo sürücü'];
        });


        Master::page('footer', function () {
            return ['signature'=>'hmvc php'];
        });
    }
}
