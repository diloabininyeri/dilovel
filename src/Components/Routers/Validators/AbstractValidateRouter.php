<?php


namespace App\Components\Routers\Validators;

/**
 * Class AbstractValidateRouter
 * @package App\Components\Routers\Validators
 */
abstract class AbstractValidateRouter
{
    /**
     * @param $value
     * @param $type
     * @return bool
     *
     */

    public function validate($value, $type): bool
    {
        $class=$this->getTypes()[$type];
        return (new $class())->validate($value);
    }

    /**
     * @return mixed
     */
    private function getTypes(): array
    {
        return $this->type;
    }
}
