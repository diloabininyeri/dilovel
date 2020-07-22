<?php


namespace App\Components\Route\Validators;

/**
 * Class ValidateRouter
 * @package App\Components\Route\Validators
 */
class ValidateRouter extends AbstractValidateRouter
{

    /**
     * @var array|string[]
     */
    protected array $type = [

        'int' => ValidateRouterParamInt::class,
        'string' => ValidateRouterParamString::class,
        'date' => ValidateRouterParamDate::class
    ];
}
