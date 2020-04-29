<?php


namespace App\Components\Routers\Validators;


/**
 * Class ValidateRouter
 * @package App\Components\Routers\Validators
 */
class ValidateRouter extends AbstractValidateRouter
{

    /**
     * @var array|string[]
     */
    protected array $type=[

        'int'=>ValidateRouterParamInt::class,
        'string'=>ValidateRouterParamString::class
    ];
}