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
     * @param $url
     * @return bool
     */
    public function validate($url): bool
    {
        return (bool)strtotime($url);
    }
}