<?php

use App\Providers\AliasProvider;
use App\Providers\ContainerProvider;
use App\Providers\CustomDirectiveProvider;
use App\Providers\MasterPageProvider;
use App\Providers\ServiceProvider;
use App\Providers\SessionProvider;

return[

    'providers'=>[
        ServiceProvider::class,
        AliasProvider::class,
        SessionProvider::class,
        ContainerProvider::class,
        MasterPageProvider::class,
        CustomDirectiveProvider::class,
    ]
];
