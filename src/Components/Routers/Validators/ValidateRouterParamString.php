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
     * @param $value
     * @return bool
     */
    public function validate($value): bool
    {
        return is_string($value);
    }
}