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
    public function loadProviders(): void
    {
        /**
         * @var  ProviderInterface[] $providers
         */
        $config= base_path('src\app\config.php');
        $providers=include "$config";

        foreach ($providers['providers'] as $provider) {

            $provider=new $provider();
            $provider->register();
            $provider->boot();
        }

    }
}