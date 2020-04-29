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
     * @param $value
     * @return bool
     */
    public function validate($value): bool
    {

        return is_numeric($value);
    }
}