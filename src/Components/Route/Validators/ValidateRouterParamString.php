<?php


namespace App\Components\Route\Validators;

use App\Interfaces\ValidateRouterInterface;

/**
 * Class ValidateRouterParamString
 * @package App\Components\Route\Validators
 */
class ValidateRouterParamString implements ValidateRouterInterface
{

    /**
     * @param $value
     * @return bool
     */
    public function validate($value): bool
    {
        if (is_numeric($value)) {
            return false;
        }
        return is_string($value);
    }
}
