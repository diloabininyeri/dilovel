<?php


namespace App\Components\Routers\Validators;

use App\Interfaces\ValidateRouterInterface;

/**
 * Class ValidateRouterParamDate
 * @package App\Components\Routers\Validators
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
