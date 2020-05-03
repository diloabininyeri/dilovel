<?php


namespace App\Interfaces;

/**
 * Interface ValidateRouterInterface
 * @package App\Interfaces
 */
interface ValidateRouterInterface
{
    /**
     * @param $value
     * @return bool
     */
    public function validate($value):bool ;
}
