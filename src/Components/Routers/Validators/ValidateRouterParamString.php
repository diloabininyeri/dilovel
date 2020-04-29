<?php


namespace App\Components\Routers\Validators;


use App\Interfaces\ValidateRouterInterface;

/**
 * Class ValidateRouterParamString
 * @package App\Components\Routers\Validators
 */
class ValidateRouterParamString implements ValidateRouterInterface
{

    /**
     * @param $url
     * @return bool
     */
    public function validate($url): bool
    {
        return is_string($url);
    }
}