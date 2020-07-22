<?php


namespace App\Components\Route\Validators;

use App\Interfaces\ValidateRouterInterface;

/**
 * Class ValidateRouterParamInt
 * @package App\Components\Route
 */
class ValidateRouterParamInt implements ValidateRouterInterface
{


    /**
     * @param $value
     * @return bool
     */
    public function validate($value): bool
    {
        return is_numeric($value);
    }
}
