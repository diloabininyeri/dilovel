<?php


namespace App\Bootstrap;

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

/**
 * Class BeautifulError
 * @package App\Bootstrap
 */
class BeautifulError
{

    /**
     *
     */
    public static function make(): void
    {
        if (env('BEAUTIFUL_ERROR')==='true') {
            $whoops = new Run;
            $whoops->pushHandler(new PrettyPageHandler);
            $whoops->register();
        }
    }
}
