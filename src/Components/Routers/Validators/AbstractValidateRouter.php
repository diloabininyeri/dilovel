<?php


namespace App\Components\Routers\Validators;


use App\Interfaces\ValidateRouterInterface;

abstract class AbstractValidateRouter
{
    /**
     * @param $param
     * @param $type
     * @return bool
     *
     */
    public function validate($param, $type): bool
    {
        return call_user_func($this->getTypes()[$type].'::validate',$param);
    }

    /**
     * @return mixed
     */
    private function getTypes(): array
    {
        return $this->type;
    }
}