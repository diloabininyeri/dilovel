<?php


namespace App\Components\Route\Validators;

use App\Interfaces\ValidateRouterInterface;

/**
 * Class ValidateRouterParamDate
 * @package App\Components\Route\Validators
 */
class ValidateRouterParamDate implements ValidateRouterInterface
{

    /**
     * @param $value
     * @return bool
     */
    public function validate($value): bool
    {
        return (bool)strtotime($value);
    }
}
