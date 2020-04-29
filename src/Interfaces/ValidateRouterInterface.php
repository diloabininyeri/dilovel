<?php


namespace App\Interfaces;


/**
 * Interface ValidateRouterInterface
 * @package App\Interfaces
 */
interface ValidateRouterInterface
{
    /**
     * @param $url
     * @return bool
     */
    public function validate($url):bool ;
}