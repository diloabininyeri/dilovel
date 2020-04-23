<?php


namespace App\Bootstrap;


class Application
{


    public static function run()
    {

        $bootstrap = new Bootstrap();
        $bootstrap->loadProiders();
    }
}