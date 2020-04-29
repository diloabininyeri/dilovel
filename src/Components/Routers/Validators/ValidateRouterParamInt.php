<?php


namespace App\Components\Routers\Validators;


use App\Interfaces\ValidateRouterInterface;

/**
 * Class ValidateRouterParamInt
 * @package App\Components\Routers
 */
class ValidateRouterParamInt implements ValidateRouterInterface
{


    /**
     * @param $url
     * @return bool
     */
    public function validate($url): bool
    {
        return is_int($url);
    }
}