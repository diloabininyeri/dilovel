<?php


namespace App\Application\Routervalidators;

use App\Interfaces\ValidateRouterInterface;

/**
 * Class RouterParamIsNumeric
 * @package App\Application\Routervalidators
 */
class RouterParamIsNumeric implements ValidateRouterInterface
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
