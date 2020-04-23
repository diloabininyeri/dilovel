<?php


namespace App\Bootstrap;


use App\Providers\ProviderInterface;

/**
 * Class Bootstrap
 * @package App\Bootstrap
 */
class Bootstrap
{


    /**
     *
     */
    function loadProiders()
    {
        /**
         * @var  ProviderInterface[] $providers
         */
        $providers=include base_path('src\app\config.php');

        foreach ($providers['providers'] as $provider) {

            $provider=new $provider();
            $provider->register();
            $provider->boot();
        }

    }
}