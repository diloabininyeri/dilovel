<?php


namespace App\Application\Routervalidators;

use App\Components\Route\Validators\ValidateRouter;

/**
 * Class Validator
 * @package App\Application\Routervalidators
 */
class Validator
{
    /**
     * @var array|string[]
     * @see ValidateRouter::$type
     */
    private array $validators=[
        'is_numeric'=>RouterParamIsNumeric::class,
    ];

    /**
     * @return array|string[]
     */
    public function getTypes():array
    {
        return $this->validators;
    }
}
